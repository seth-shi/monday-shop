jQuery.fn.rater = function (options) {
    var settings = {
        enabled: true,
        url: '',
        method: 'post',
        min: 1,
        max: 5,
        step: 1,
        value: null,
        after_click: null,
        before_ajax: null,
        after_ajax: null,
        title_format: null,
        info_format: null,
        image: '/images/stars.jpg',
        imageAll: '/images/stars-all.gif',
        defaultTips: true,
        clickTips: true,
        width: 24,
        height: 24
    };
    if (options) {
        jQuery.extend(settings, options);
    }
    var container = jQuery(this);
    var content = jQuery('<ul class="rater-star"></ul>');
    content.css('background-image', 'url(' + settings.image + ')');
    content.css('height', settings.height);
    content.css('width', (settings.width * settings.step) * (settings.max - settings.min + settings.step) / settings.step);
    var result = jQuery('<div data-star="0" class="rater-star-result"></div>');
    container.after(result);
    var clickTips = jQuery('<div class="rater-click-tips"><span>点击星星就可以评分了</span></div>');
    if (!settings.clickTips) {
        clickTips.hide();
    }
    container.after(clickTips);
    var tipsItem = jQuery('<li class="rater-star-item-tips"></li>');
    tipsItem.css('width', (settings.width * settings.step) * (settings.max - settings.min + settings.step) / settings.step);
    tipsItem.css('z-index', settings.max / settings.step + 2);
    if (!settings.defaultTips) {
        tipsItem.hide();
    }
    content.append(tipsItem);
    var item = jQuery('<li class="rater-star-item-current"></li>');
    item.css('background-image', 'url(' + settings.image + ')');
    item.css('height', settings.height);
    item.css('width', 0);
    item.css('z-index', settings.max / settings.step + 1);
    if (settings.value) {
        item.css('width', ((settings.value - settings.min) / settings.step + 1) * settings.step * settings.width);
    }
    ;content.append(item);
    for (var value = settings.min; value <= settings.max; value += settings.step) {
        item = jQuery('<li class="rater-star-item"><div class="popinfo"></div></li>');
        if (typeof settings.info_format == 'function') {
            item.find(".popinfo").html(settings.info_format(value));
            item.find(".popinfo").css("left", (value - 1) * settings.width)
        } else {
            item.attr('title', value);
        }
        item.css('height', settings.height);
        item.css('width', (value - settings.min + settings.step) * settings.width);
        item.css('z-index', (settings.max - value) / settings.step + 1);
        item.css('background-image', 'url(' + settings.image + ')');
        if (!settings.enabled) {
            item.hide();
        }
        content.append(item);
    }
    content.mouseover(function () {
        if (settings.enabled) {
            jQuery(this).find('.rater-star-item-current').hide();
        }
    }).mouseout(function () {
        jQuery(this).find('.rater-star-item-current').show();
    })
    var shappyWidth = (settings.max - 2) * settings.width;
    var happyWidth = (settings.max - 1) * settings.width;
    var fullWidth = settings.max * settings.width;
    content.find('.rater-star-item').mouseover(function () {
        jQuery(this).prevAll('.rater-star-item-tips').hide();
        jQuery(this).attr('class', 'rater-star-item-hover');
        jQuery(this).find(".popinfo").show();
        if (parseInt(jQuery(this).css("width")) == shappyWidth) {
            jQuery(this).addClass('rater-star-happy');
        }
        if (parseInt(jQuery(this).css("width")) == happyWidth) {
            jQuery(this).addClass('rater-star-happy');
        }
        if (parseInt(jQuery(this).css("width")) == fullWidth) {
            jQuery(this).removeClass('rater-star-item-hover');
            jQuery(this).css('background-image', 'url(' + settings.imageAll + ')');
            jQuery(this).css({cursor: 'pointer', position: 'absolute', left: '0', top: '0'});
        }
    }).mouseout(function () {
        var outObj = jQuery(this);
        outObj.css('background-image', 'url(' + settings.image + ')');
        outObj.attr('class', 'rater-star-item');
        outObj.find(".popinfo").hide();
        outObj.removeClass('rater-star-happy');
        jQuery(this).prevAll('.rater-star-item-tips').show();
    }).click(function () {
        jQuery(this).parents(".rater-star").find(".rater-star-item-tips").remove();
        jQuery(this).parents(".goods-comm-stars").find(".rater-click-tips").remove();
        jQuery(this).prevAll('.rater-star-item-current').css('width', jQuery(this).width());
        if (parseInt(jQuery(this).prevAll('.rater-star-item-current').css("width")) == happyWidth || parseInt(jQuery(this).prevAll('.rater-star-item-current').css("width")) == shappyWidth) {
            jQuery(this).prevAll('.rater-star-item-current').addClass('rater-star-happy');
        } else {
            jQuery(this).prevAll('.rater-star-item-current').removeClass('rater-star-happy');
        }
        if (parseInt(jQuery(this).prevAll('.rater-star-item-current').css("width")) == fullWidth) {
            jQuery(this).prevAll('.rater-star-item-current').addClass('rater-star-full');
        } else {
            jQuery(this).prevAll('.rater-star-item-current').removeClass('rater-star-full');
        }
        var star_count = (settings.max - settings.min) + settings.step;
        var current_number = jQuery(this).prevAll('.rater-star-item').size() + 1;
        var current_value = settings.min + (current_number - 1) * settings.step;
        if (typeof settings.title_format == 'function') {

            var dom = jQuery(this).parents().nextAll('.rater-star-result');
            dom.data('star', current_value)
            dom.html(current_value + '分&nbsp;' + settings.title_format(current_value));
        }
        $("#StarNum").val(current_value);
    })
    jQuery(this).html(content);
}
$(function () {
    var options = {
        max: 5, title_format: function (value) {
            var title = '';
            switch (value) {
                case 1:
                    title = '很不满意';
                    break;
                case 2:
                    title = '不满意';
                    break;
                case 3:
                    title = '一般';
                    break;
                case 4:
                    title = '满意';
                    break;
                case 5:
                    title = '非常满意';
                    break;
                default:
                    title = value;
                    break;
            }
            return title;
        }, info_format: function (value) {
            var info = '';
            switch (value) {
                case 1:
                    info = '<div class="info-box">1分&nbsp;很不满意<div>商品样式和质量都非常差，太令人失望了！</div></div>';
                    break;
                case 2:
                    info = '<div class="info-box">2分&nbsp;不满意<div>商品样式和质量不好，不能满足要求。</div></div>';
                    break;
                case 3:
                    info = '<div class="info-box">3分&nbsp;一般<div>商品样式和质量感觉一般。</div></div>';
                    break;
                case 4:
                    info = '<div class="info-box">4分&nbsp;满意<div>商品样式和质量都比较满意，符合我的期望。</div></div>';
                    break;
                case 5:
                    info = '<div class="info-box">5分&nbsp;非常满意<div>我很喜欢！商品样式和质量都很满意，太棒了！</div></div>';
                    break;
                default:
                    info = value;
                    break;
            }
            return info;
        }
    }
    $('#rate-comm-1').rater(options);
});