const $ = jQuery;

export class UrlPostMetaBoxManager
{
    classes = {
        main: 'hwpro-url-meta-box',
        url: {
            pathField: 'hwpro-url-path',
            finalUrl: 'hwpro-url-path-final',
            finalUrlPath: 'hwpro-url-path-final--path'
        },
        stats: {
            number: 'hwpro-stats--number'
        }
    }

    elements = {};

    constructor() 
    {
        this.elements.main = $(`.${this.classes.main}`);
        this.elements.pathField = $(`#${this.classes.url.pathField}`);

        if (this.elements.pathField.length) {
            this.elements.finalUrl = $(`.${this.classes.url.finalUrl}`);

            this.elements.pathField.get(0) && this.elements.pathField.get(0).addEventListener('input', this.updatePath.bind(this));

            this.elements.statsNumber = $(`.${this.classes.stats.number}`)
            this.performStatsRequest();
        }
    }

    updatePath({target}) 
    {
        const fixedPath = target.value.replace(' ', '-').replace(/[^a-z0-9-]/gi,'');

        this.elements.pathField.val(fixedPath);
        this.updateFinalUrl(fixedPath);
    }

    updateFinalUrl(path) 
    {
        this.elements.finalUrl.children(`.${this.classes.url.finalUrlPath}`)
                              .text(path);
    }

    performStatsRequest() 
    {
        if (this.getUrlId() < 1) {
            return;
        }

        $.ajax({
            method: 'GET',
            url: window.HighWayProPostEditor.postUrl,
            data: {
                action: 'highwaypro_post',
                path: 'url/statistics',
                data: JSON.stringify({
                    url: {
                        id: this.getUrlId()
                    }
                })
            },
            dataType: 'json',
            beforeSend: () => this.setClicksValue('Loading'),
            success: this.handleSuccessfulStatsResponse.bind(this),
            error: () => this.setClicksValue('Failed to load')
        })
    }

    getUrlId() 
    {
        return this.elements.main.attr('data-url-id');
    }

    handleSuccessfulStatsResponse(response) 
    {
        this.setClicksValue(response.statistics.count.allTime)
    }

    setClicksValue(value) 
    {
        this.elements.statsNumber.text(value)
    }
}