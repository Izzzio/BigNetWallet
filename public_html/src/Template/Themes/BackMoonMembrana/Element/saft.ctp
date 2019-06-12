
<div class="modal fade saft-dialog" id="second-step-registration" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Personal data</h4>
            </div>

            <div class="modal-body">
                <form id="saft-form">
                    <div align="center" id="case-buttons">
                        <div class="btn-group" align="center" data-toggle="buttons">
                            <label class="btn btn-primary active" id="case-company">
                                <input type="radio" name="options" autocomplete="off" checked> Company
                            </label>
                            <label class="btn btn-primary" id="case-individual">
                                <input type="radio" name="options" autocomplete="off"> Individual
                            </label>
                        </div>
                    </div>

                    <div class="company-block">
                        <div class="form-group">
                            <label for="company-name">Company name</label>
                            <input name="company-name" type="text" class="input-field" id="company-name" placeholder="Name..." required>
                        </div>

                        <div class="form-group">
                            <label for="company-registration-number">Company registration number</label>
                            <input name="registration_number" type="text" class="input-field" id="company-registration-number" placeholder="Number..." required>
                        </div>

                        <div class="form-group">
                            <label for="company-registration-number">Company registration address</label>
                            <div class="row">
                                <div class="col-xs-12"  style="padding-bottom: 10px">
                                    <input name="address" type="text" class="input-field" placeholder="Address..." required>
                                </div>

                                <div class="col-xs-12" style="padding-bottom: 10px">
                                    <input name="city" type="text" class="input-field" placeholder="City..." required>
                                </div>

                                <div class="col-xs-12" style="padding-bottom: 10px">
                                    <input name="zipcode" type="text" class="input-field" placeholder="ZIPcode..." required>
                                </div>

                                <div class="col-xs-12" style="padding-bottom: 10px">
                                    <select name="country" class="js-example-basic-single input-field"  style="color: black; width: 100%" name="state">
                                        <?php foreach (\App\Lib\Misc::COUNTRY as $country) { ?>
                                            <option value="<?= $country ?>"><?= $country ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="representative-full-name">Representative Full name</label>
                            <input name="representative_name" type="text" class="input-field" id="representative-full-name" placeholder="name..." required>
                        </div>

                        <div class="form-group">
                            <label for="date-of-birth">Representative Date of Birth</label>
                            <input name="birthdate" class="datepicker input-field" data-date-format="mm/dd/yyyy" required>
                        </div>
                    </div>

                    <div class="individual-block">
                        <div class="form-group">
                            <label for="individual-name">Full name</label>
                            <input name="fullname" type="text" class="input-field" id="individual-name" placeholder="Name..." required>
                        </div>

                        <div class="form-group">
                            <label for="date-of-birth">Date of Birth</label>
                            <input name="birthdate" class="datepicker input-field" data-date-format="mm/dd/yyyy" required>
                        </div>

                        <div class="form-group">
                            <label for="company-name">Passport / ID number</label>
                            <input name="passport" type="text" class="input-field" id="individual-id" placeholder="id..." required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone number</label>
                            <input name="phone" type="text" class="input-field" id="phone-number" placeholder="+" required>
                        </div>

                        <div class="form-group">
                            <label for="individual-nationality">Nationality</label>
                            <div class="row">
                                <div class="col-xs-4">
                                    <select name="nationality" style="width: 100%; color: black" class="js-example-basic-single input-field" id="individual-nationality" required>
                                        <option value="" disabled selected>Select country</option>
                                        <?php foreach (\App\Lib\Misc::COUNTRY as $country) { ?>
                                            <option value="<?= $country ?>"><?= $country ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="individual-registration-number">Residential address</label>
                            <div class="row">
                                <div class="col-xs-12" style="padding-bottom: 10px">
                                    <input name="address" type="text" class="input-field" placeholder="Address..." required>
                                </div>

                                <div class="col-xs-12" style="padding-bottom: 10px">
                                    <input name="city" type="text" class="input-field" placeholder="City..." required>
                                </div>

                                <div class="col-xs-12" style="padding-bottom: 10px">
                                    <input name="zipcode" type="text" class="input-field" placeholder="ZIPcode..." required>
                                </div>

                                <div class="col-xs-12" style="padding-bottom: 10px">
                                    <select name="country" class="js-example-basic-single input-field"  style="color: black; width: 100%" required>
                                        <option value="" disabled selected>Select country</option>
                                        <?php foreach (\App\Lib\Misc::COUNTRY as $country) { ?>
                                            <option value="<?= $country ?>"><?= $country ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="confirmations">

                        <div style="display: none" id="chinaMessage"></div>

                       <!-- <div class="checkbox">
                            <label>
                                <input name="terms" type="checkbox"> I agree with <a href="<?=\App\Lib\Misc::links('terms')?>" target="_blank">Terms of Service</a>
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input name="privacy" type="checkbox"> I agree with <a href="<?=\App\Lib\Misc::links('privacy')?>" target="_blank">Privacy policy</a>
                            </label>
                        </div> -->



                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                <button type="submit" id="saveButton" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/css/saft.css?_=<?=rand()?>">
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/saft.js?_=<?=rand()?>"></script>
<?=\App\Lib\Sandbox::runFromStorageOrIgnore('extraSaft')?>