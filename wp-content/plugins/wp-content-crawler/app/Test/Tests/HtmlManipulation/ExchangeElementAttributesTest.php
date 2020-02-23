<?php
/**
 * Created by PhpStorm.
 * User: turgutsaricam
 * Date: 25/10/2018
 * Time: 18:37
 */

namespace WPCCrawler\Test\Tests\HtmlManipulation;


use Symfony\Component\DomCrawler\Crawler;
use WPCCrawler\Objects\Crawling\Bot\PostBot;
use WPCCrawler\Objects\Settings\Enums\SettingInnerKey;
use WPCCrawler\Test\Base\AbstractHtmlManipulationTest;
use WPCCrawler\Test\Base\AbstractTest;
use WPCCrawler\Test\Data\TestData;
use WPCCrawler\Utils;

class ExchangeElementAttributesTest extends AbstractHtmlManipulationTest {

    private $url;
    private $content;
    private $selector;
    private $attr1;
    private $attr2;

    /**
     * Get the last HTML manipulation step. See {@link applyHtmlManipulationOptions}
     *
     * @return null|int
     */
    protected function getLastHtmlManipulationStep() {
        return AbstractTest::MANIPULATION_STEP_FIND_REPLACE_ELEMENT_ATTRIBUTES;
    }

    /**
     * Define instance variables.
     * @return void
     */
    protected function defineVariables() {
        $this->url      = $this->getData()->get("url");
        $this->content  = $this->getData()->get("subject");
        $this->selector = Utils::array_get($this->getData()->getFormItemValues(), SettingInnerKey::SELECTOR);
        $this->attr1    = Utils::array_get($this->getData()->getFormItemValues(), SettingInnerKey::ATTRIBUTE_1);
        $this->attr2    = Utils::array_get($this->getData()->getFormItemValues(), SettingInnerKey::ATTRIBUTE_2);
    }

    /**
     * @return string
     */
    protected function getMessageLastPart() {
        return sprintf('%1$s %2$s %3$s',
            $this->selector   ? "<span class='highlight selector'>" . $this->selector . "</span>"   : '',
            $this->attr1      ? "<span class='highlight attribute'>" . $this->attr1 . "</span>"     : '',
            $this->attr2      ? "<span class='highlight attribute'>" . $this->attr2 . "</span>"     : ''
        );
    }

    /**
     * Returns a manipulated {@link Crawler}. {@link PostBot} is the bot that is used to get the data from the target
     * URL and it can be used to manipulate the content.
     *
     * @param Crawler $crawler
     * @param PostBot $bot
     * @return Crawler
     */
    protected function manipulate($crawler, $bot) {
        $bot->exchangeElementAttributeValues($crawler, [$this->selector], $this->attr1, $this->attr2);
        return $crawler;
    }

    /**
     * Conduct the test and return an array of results.
     *
     * @param TestData $data Information required for the test
     * @return array|string|mixed
     */
    protected function createResults($data) {
        if (parent::createResults($data) === null) return null;

        return $this->createHtmlManipulationResults($this->url, $this->content, $this->selector, $this->getMessageLastPart());
    }
}