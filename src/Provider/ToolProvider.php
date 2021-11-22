<?php

namespace Kpg\Chart\Provider;

use ILIAS\GlobalScreen\Scope\Tool\Provider\AbstractDynamicToolPluginProvider;
use ILIAS\GlobalScreen\ScreenContext\Stack\ContextCollection;
use ILIAS\GlobalScreen\ScreenContext\Stack\CalledContexts;

include_once "./Customizing/global/plugins/Services/COPage/PageComponent/Chart/classes/class.ilChartPluginGUI.php";

class ToolProvider extends AbstractDynamicToolPluginProvider
{
    const LANG_CHART_TITLE = "chart_title";
    const LANG_CHART_DATASETS = "chart_datasets";
    const LANG_CHART_HORIZONTAL_BAR = "horizontal_bar_chart";
    const LANG_CHART_VERTICAL_BAR = "vertical_bar_chart";
    const LANG_CHART_PIE_CHART = "pie_chart";
    const LANG_CHART_LINE_CHART = 'line_chart';
    const LANG_CHART_TYPE = "chart_type";
    const SHOW_EDITOR = "copg_show_editor";
    const TPL_FILE = "tpl.editor_slate.html";

    public function getToolsForContextStack(CalledContexts $called_contexts) : array
    {
        $tools = [];
        $additional_data = $called_contexts->current()->getAdditionalData();

        if ($additional_data->is(self::SHOW_EDITOR, true)) {
            var_dump("OK");
            /*$title = $this->dic->language()->txt('editor');
            $icon = $this->dic->ui()->factory()->symbol()->icon()->custom(\ilUtil::getImagePath("outlined/icon_edtr.svg"), $title);
            $iff = function ($id) {
                return $this->identification_provider->contextAwareIdentifier($id);
            };
            $l = function (string $content) {
                return $this->dic->ui()->factory()->legacy($content);
            };
            $tools[] = $this->factory->tool($iff("copg_editor"))
                ->withSymbol($icon)
                ->withTitle($title)
                ->withContent($l('<p>Hello</p>'));*/
        }
        /*if ($additional_data->is(self::SHOW_EDITOR, true)) {

        }*/

        $title = $this->dic->language()->txt('editor');
        $icon = $this->dic->ui()->factory()->symbol()->icon()->custom(\ilUtil::getImagePath("outlined/icon_edtr.svg"), $title);

        $iff = function ($id) {
            //var_dump($this->identification_provider->contextAwareIdentifier($id));
            return $this->identification_provider->contextAwareIdentifier($id);
        };
        $l = function (string $content) {
            return $this->dic->ui()->factory()->legacy($content);
        };
        $tools[] = $this->factory->tool($iff("copg_editor"))
            ->withSymbol($icon)
            ->withTitle($title)
            ->withContent($l($this->getContent()));

        return $tools;
    }

    public function isInterestedInContexts() : ContextCollection
    {
        return $this->context_collection->main()->repository();
    }

    private function getContent()
    {
        global $DIC;
        $lng = $DIC->language();
        $lng->loadLanguageModule("content");

        $pl = new \ilChartPlugin();

        /*$gui = new \ilChartPluginGUI();
        $properties = $gui->getProperties();*/
        $gui = new \ilChartPluginGUI();
        //$prop = $gui->getProperties();

        //var_dump($properties);
        $form = new \ilPropertyFormGUI();
        $titleChart = new \ilTextInputGUI($pl->txt(self::LANG_CHART_TITLE), "chart_title");
        $titleChart->setRequired(false);
        $titleChart->setValue("test");
        $form->addItem($titleChart);

        $selectChartType = new \ilSelectInputGUI($pl->txt(self::LANG_CHART_TYPE), "chart_type");
        $selectChartType->setRequired(true);
        $optionsChart = [
            "1" => $pl->txt(self::LANG_CHART_HORIZONTAL_BAR),
            "2" => $pl->txt(self::LANG_CHART_VERTICAL_BAR),
            "3" => $pl->txt(self::LANG_CHART_PIE_CHART),
            "4" => $pl->txt(self::LANG_CHART_LINE_CHART)
        ];
        $selectChartType->setOptions($optionsChart);
        $selectChartType->setValue($prop["chart_type"]);
        $form->addItem($selectChartType);

        return $form->getHTML();
        /*$pl = new \ilChartPlugin();
        $tpl = $pl->getTemplate(self::TPL_FILE, true, true);
        $tpl->setCurrentBlock("chart_title");
        $tpl->setVariable("TXT_ADD_EL", $lng->txt("cont_add_elements"));*/
        //$tpl->setVariable("PLUS", ilGlyphGUI::get(ilGlyphGUI::ADD));
        //$tpl->setVariable("DRAG_ARROW", ilGlyphGUI::get(ilGlyphGUI::DRAG));
        //$tpl->setVariable("TXT_DRAG", $lng->txt("cont_drag_and_drop_elements"));
        //$tpl->setVariable("TXT_SEL", $lng->txt("cont_double_click_to_delete"));
       /* $tpl->parseCurrentBlock();
        return $tpl->get();*/
    }
}