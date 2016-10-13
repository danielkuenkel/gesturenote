<div id="template-general-container" class="hidden">

    <!-- register modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-register">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?php echo $lang->createAccount ?></h4>
                </div>
                <div class="modal-body">
                    <div class="alert-space alert-general-error"></div>
                    <div class="alert-space alert-missing-fields"></div>
                    <div class="alert-space alert-register-success"></div>

                    <div id="register-form">
                        <div class="form-group">
                            <label for="forename"><?php echo $lang->forename ?></label>
                            <input type="text" class="form-control" name="forename" id="forename" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="surname"><?php echo $lang->surname ?></label>
                            <input type="text" class="form-control" name="surname" id="surname" placeholder="">
                        </div>

                        <div class="alert-space alert-user-exists"></div>
                        <div class="alert-space alert-invalid-email"></div>

                        <div class="form-group">
                            <label for="email"><?php echo $lang->email ?></label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="">
                        </div>

                        <div class="alert-space alert-password-short"></div>
                        <div class="alert-space alert-password-invalid"></div>
                        <div class="alert-space alert-passwords-not-matching"></div>

                        <div class="form-group">
                            <label for="password"><?php echo $lang->password ?></label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword"><?php echo $lang->passwordConfirm ?></label>
                            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="">
                        </div>

                        <div class="alert-space alert-invalid-birthday"></div>

                        <div class="form-group">
                            <label><?php echo $lang->birthdate ?></label>
                            <div class="input-group">
                                <span class="input-group-addon"><?php echo $lang->day ?></span>
                                <input class="form-control" id="date" type="text" placeholder="z.B. 1" minlength="1" maxlength="2"/>
                                <span class="input-group-addon"><?php echo $lang->month ?></span>
                                <input class="form-control" id="month" type="text" placeholder="z.B. 12" minlength="1" maxlength="2"/>
                                <span class="input-group-addon"><?php echo $lang->year ?></span>
                                <input class="form-control" id="year" type="text" placeholder="z.B. 1980" minlength="4" maxlength="4"/>
                            </div>
                        </div>

                        <div class="form-group root" id="gender">
                            <label><?php echo $lang->gender ?></label><br>

                            <div class="btn-group" id="radio">
                                <button class="btn btn-default btn-radio" name="primary" id="female">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->gendersRegister->female ?></span>
                                </button>
                            </div>

                            <div class="btn-group" id="radio">
                                <button class="btn btn-default btn-radio" name="primary" id="male">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->gendersRegister->male ?></span>
                                </button>
                            </div>

                        </div>

                        <div class="form-group root" id="userType">
                            <label><?php echo $lang->userType ?></label><br>

                            <div class="btn-group" id="radio">
                                <button class="btn btn-default btn-radio" name="primary" id="tester">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->userTypesRegister->tester ?></span>
                                </button>
                            </div>

                            <div class="btn-group" id="radio">
                                <button class="btn btn-default btn-radio" name="primary" id="evaluator">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->userTypesRegister->evaluator ?></span>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-block btn-success hidden" id="btn-close"><span class="btn-text"><?php echo $lang->close ?></span></button>
                    <button type="button" class="btn btn-block btn-gn" id="btn-register"><i class="fa fa-user-plus" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->register ?></span></button>
                </div>
            </div>
        </div>
    </div>

</div>
