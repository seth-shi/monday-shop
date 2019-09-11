<style>
    .coupon_form {
        padding: 30px;
        background: #fff;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 999;
        display: none;
    }
    .coupon_form p {
        font-size: 14px;
        color: #999;
        line-height: 16px;
        letter-spacing: 0;
        margin: 0;
        margin-bottom: 10px;
    }
    .coupon_form .input {
        position: relative;
        height: auto;
        margin-bottom: 10px;
        padding: 0;
        background: #fff;
    }
    .coupon_form .input input {
        display: block;
        width: 100%;
        height: auto;
        padding: 10px;
        line-height: 20px;
        font-size: 14px;
        background: #F7F7F7;
        box-sizing: border-box;
    }
    .coupon_form .input span {
        height: 100%;
    }
    .coupon_form .input span {
        display: block;
        width: 40px;
        height: 40px;
        position: absolute;
        right: 0;
        top: 0;
        background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoBAMAAAB+0KVeAAAAJFBMV…hOwu14TG9iBgjuoMMMZMzowB1xmFGMmRgIJBtEAqMzAADxKShBw/t8QgAAAABJRU5ErkJggg==) no-repeat center;
        background-size: 20px 20px;
    }
    .coupon_form .input.input_error input {
        color: #e4393c;
    }
    .coupon_form .mod_btns {
        margin: 10px 0;
    }
    .mod_btns .mod_btn.bg_1, .mod_blockTips .btn {
        background: #e4393c;
        color: #fff;
    }
    .mod_btns .mod_btn {
        display: block;
        width: auto;
        height: 24px;
        line-height: 30px;
        text-align: center;
        font-size: 1rem;
        -webkit-border-radius: 2px;
        border-radius: 2px;
        position: relative;
        padding: 5px 0;
        box-sizing: content-box;
    }
</style>
<div class="coupon_form" id="coupon_code_form">
    <span id="close_code_btn" style="position: absolute; top: 0; right: 10px; color: red;font-weight: bold;font-size: 24px;cursor: pointer">X</span>
    <p>1、兑换码获取：参与京东活动有机会获得优惠券兑换码。兑换码由16位数字和字母组合而成。<br>

        2、兑换码使用：在当前页面输入兑换码即可兑换相应优惠券。一个兑换码只能兑换一张优惠券，不可重复使用。<br>

        3、提示：输入兑换码时请使用英文输入法。<br></p>
    <div class="input " tag="input_cdkey">
        <input type="text" tag="cdKey" placeholder="请输入16位兑换码">
        <span tag="clear"></span>
    </div>
    <div class="input input_error" tag="cdkey_error" style="display:none;">
        <input type="text">
    </div>
    <div class="input_group">

        <div class="input input_error" tag="code_error" style="display:none;">
            <input type="text" tag="errcode" value="111">
        </div>

    </div>
    <div class="mod_btns">
        <a href="javascript:;" class="mod_btn bg_1" tag="exchangeBtn" ptag="7212.1.1" wxptag="7212.1.1" mqptag="7212.2.1">立即兑换</a>
    </div>
</div>
<script>
    $('body').on('click', '.show_coupon_code_btn', function () {

        $('#coupon_code_form').show(500);
    });

    $('#close_code_btn').click(function () {

        $('#coupon_code_form').hide(500);
    });
</script>