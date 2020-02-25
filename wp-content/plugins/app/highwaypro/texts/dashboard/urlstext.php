<?php

namespace HighWayPro\App\HighWayPro\Texts\Dashboard;

use HighWayPro\App\HighWayPro\Texts\TextComponent;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;

Class UrlsText extends TextComponent
{
    const name = 'urls';

    protected static function registerTexts()
    {
        return new Collection([
            'noItemsTitle' => esc_html__('No *', Env::textDomain()),
            'noItemsMessage' => esc_html__('You have not created any *, hit add new to get started', Env::textDomain()),

            'urls' => esc_html__('urls', Env::textDomain()),
            'url' => esc_html__('url', Env::textDomain()),
            'urlType' => esc_html__('url type', Env::textDomain()),

            'new' => esc_html__('new', Env::textDomain()),
            'createNew' => esc_html__('Create New', Env::textDomain()),
            'createNewType' => esc_html__('Create New *', Env::textDomain()),

            'urlNameHelper' => esc_html__('The name of the url. Only letters, numbers and one or more spaces are accepted.', Env::textDomain()),
            'urlPathHelper' => esc_html__('The path of the url. Only one level is allowed. Only letters, numbers and/or dashes are accepted.', Env::textDomain()),


            'analytics' => __('Analytics', Env::textDomain()),
            'routes' => __('Routes', Env::textDomain()),


            'toolsAndPreferences' => __('Tools & Preferences', Env::textDomain()),
            'loadingPreferences' => __('Loading Preferences..', Env::textDomain()),

            'dynamicLinkInsertionTitle' => __('Dynamic Link Insertion', Env::textDomain()),
            'dynamicLinkInsertionDescription' => __("Assign this url to the specified Keywords from your site's content", Env::textDomain()), 
            'dynamicLinkInsertionLabel' => __('Enter keywords separated by a coma. Eg: Toys, small toys...', Env::textDomain()),
            'dynamicLinkInsertionHelper' => __('Separate keywords with a coma (,). Phrases (more than one word) will take precedence over single words. If you had: toys and blue toys, the algorithm would first assign links to "blue toys".', Env::textDomain()),
            'keywordsLimitTitle' => __('Max. # of insertions per keyword: ', Env::textDomain()),

            'inContentLinksTitle' => __('In-Content Links', Env::textDomain()),
            'inContentLinksDescription' => __("Options for the behaviour of links with this url inside your content.", Env::textDomain()), 

            'fields' => [
                'basePath' => __("Base Path", Env::textDomain()), 
                'basePath_short' => __("Base", Env::textDomain()), 
                'path' => __("Path", Env::textDomain()), 
                'name' => __("Name", Env::textDomain()), 
            ],
            'view' => __("View", Env::textDomain()), 

            'urlTypeBaseUrlMessage' => __('Please note: the base path you assign to this url type does not conflict with other one-segment WordPress paths like those assigned to pages. For example, if you had a page named: *, WordPress would still serve a page with the path "/*". If you define a base path, HighWayPro will only take control of the request when the path has two segments (the base and the short url path)', Env::textDomain()),
        ]);
    }
    
}