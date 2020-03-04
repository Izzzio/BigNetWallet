<div class="cab-wrapper cab-main-form saft-dialog" id="second-step-registration" style="display: none;">
    <div class="cab-container">
        <img src="img/cabinet/logo.svg" alt="Cryptoindex" class="cab-main-form__logo">
        <form action="#" method="post" class="cab-main-form__wrap">
            <h1 class="cab-main-form__title">Individual personal data</h1>
            <label class="input-wrap input-wrap--name">
                    <span class="input--nariko">
                        <input class="input__field input__field--nariko" type="text" name="name">
                        <span class="input__label--nariko">
                            <span class="input__label-content input__label-content--nariko">Full name</span>
                        </span>
                    </span>
            </label>
            <label class="input-wrap input-wrap--name">
                    <span class="input--nariko">
                        <input class="input__field input__field--nariko" type="date" name="date">
                        <span class="input__label--nariko">
                            <span class="input__label-content input__label-content--nariko">Date of Birth</span>
                        </span>
                    </span>
            </label>
            <label class="input-wrap input-wrap--name">
                    <span class="input--nariko">
                        <input class="input__field input__field--nariko" type="text" name="id">
                        <span class="input__label--nariko">
                            <span class="input__label-content input__label-content--nariko">Passport / ID number</span>
                        </span>
                    </span>
            </label>
            <label class="input-wrap input-wrap--name">
                    <span class="input--nariko">
                        <input class="input__field input__field--nariko" type="tel" name="tel">
                        <span class="input__label--nariko">
                            <span class="input__label-content input__label-content--nariko">Phone number</span>
                        </span>
                    </span>
            </label>
            <div class="input-wrap input-wrap--name cab-main-form__dropgroup js-dropgroup">
                    <span class="input--nariko">
                        <input class="input__field input__field--nariko" type="text" name="nationality" disabled>
                        <span class="input__label--nariko">
                            <span class="input__label-content input__label-content--nariko">Nationality</span>
                        </span>
                    </span>
                <div class="cab-main-form__drop js-mainform-drop">
                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="America">America</div>
                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="Trinidad and Tobago">Trinidad and Tobago</div>
                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="Russia">Russia</div>
                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="North Korea">North Korea</div>
                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="Papua New Guinea">Papua New Guinea</div>
                </div>
            </div>
            <div class="cab-main-form__subtitle">Residential address</div>
            <div class="input-wrap input-wrap--name cab-main-form__dropgroup js-dropgroup">
                    <span class="input--nariko">
                        <input class="input__field input__field--nariko" type="text" name="country" disabled>
                        <span class="input__label--nariko">
                            <span class="input__label-content input__label-content--nariko">Select country</span>
                        </span>
                    </span>
                <div class="cab-main-form__drop js-mainform-drop">
                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="America">America</div>
                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="Trinidad and Tobago">Trinidad and Tobago</div>
                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="Russia">Russia</div>
                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="North Korea">North Korea</div>
                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="Papua New Guinea">Papua New Guinea</div>
                </div>
            </div>
            <label class="input-wrap input-wrap--name">
                    <span class="input--nariko">
                        <input class="input__field input__field--nariko" type="text" name="city">
                        <span class="input__label--nariko">
                            <span class="input__label-content input__label-content--nariko">City</span>
                        </span>
                    </span>
            </label>
            <label class="input-wrap input-wrap--name">
                    <span class="input--nariko">
                        <input class="input__field input__field--nariko" type="text" name="address">
                        <span class="input__label--nariko">
                            <span class="input__label-content input__label-content--nariko">Address</span>
                        </span>
                    </span>
            </label>
            <label class="input-wrap input-wrap--name">
                    <span class="input--nariko">
                        <input class="input__field input__field--nariko" type="text" name="zipcode">
                        <span class="input__label--nariko">
                            <span class="input__label-content input__label-content--nariko">Zipcode</span>
                        </span>
                    </span>
            </label>
            <div class="cab-main-form__check">
                <label>
                    <input type="checkbox" name="check">
                    <span class="cab-main-form__check-dop"></span>
                </label>
                <div class="cab-main-form__check-txt">
                    I hereby acknowledge that i have read, understand and agree to the terms of this <a href="#">SAFT</a> relating to the sale of tokens, <a href="#">Privacy Policy</a>, <a href="#">Terms and Conditions</a> and <a href="#">White Paper</a>
                </div>
            </div>
            <button class="btn cab-btn--blue cab-main-form__submit" type="submit">Save</button>
            <button class="btn cab-main-form__reset" type="reset">Cancel</button>
        </form>
    </div>
</div>

<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/vendors/jquery.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/vendors/nariko.js"></script>

<!--
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/cabinet.js"></script>
-->
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/libs/izi_modal/js/iziModal.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/saft.js?_=<?=rand()?>"></script>
<?=\App\Lib\Sandbox::runFromStorageOrIgnore('extraSaft')?>