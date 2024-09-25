
<?php $__env->startSection('title', 'Registration Form'); ?>
<?php $__env->startSection('content'); ?>
<style>
    input[type="number"],
    input[type="date"] {
        background-color: var(--white);
        border: 2px solid;
        border-color: var(--border-color-9);
        height: 65px;
        -webkit-box-shadow: none;
        box-shadow: none;
        padding-left: 20px;
        font-size: 16px;
        color: var(--ltn__paragraph-color);
        width: 100%;
        margin-bottom: 30px;
        border-radius: 0;
        padding-right: 40px;
    }

    select {
        background-color: var(--white);
        border: 2px solid;
        border-color: var(--border-color-9);
        height: 65px;
        -webkit-box-shadow: none;
        box-shadow: none;
        padding-left: 20px;
        font-size: 16px;
        color: var(--ltn__paragraph-color);
        width: 100%;
        margin-bottom: 30px;
        border-radius: 30px !important;
        padding-right: 40px;
    }

    #phone::-webkit-inner-spin-button,
    #phone::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="file"]::-webkit-file-upload-button {
        height: 50px;
    }
</style>


<!-- LOGIN AREA START (Register) -->
<div class="ltn__login-area pb-110 py-5">
    <div class="container">
        <div class="row bg-white">
            <div class="crate-here ps-5 pt-4">
                <h4>Your Details</h4>
                <p>Please complete the below details to create your account and continue your consultation.</p>
                <div class="go-to-btn mt-4">
                    <a href="/admin"><strong>ALREADY HAVE AN ACCOUNT?</strong></a>
                    <a href="/admin" class="btn-primary sign-btn text-center">sign in</a>
                </div>
            </div>
            <div class="col-lg-12 pt-4">
                <form action="<?php echo e(route('web.user_register')); ?>" method="post" class=" reg-me ltn__form-box contact-form-box needs-validation" type="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="text" name="name" placeholder="Full Name" value="<?php echo e(old('name')); ?>" required>
                            <div class="invalid-feedback">Please enter your name!</div>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert-danger text-danger "><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <input type="number" id="phone" name="phone" placeholder="Phone Number" value="<?php echo e(old('phone')); ?>" required>
                            <div class="invalid-feedback">Please enter Phone Number!</div>
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert-danger text-danger "><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <select name="gender" id="gender" class="form-select" required>
                                <option value=""> Select Gender</option>
                                <option <?php echo e(old('gender') == 'male' ? 'selected' : ''); ?> value="male"> Male</option>
                                <option <?php echo e(old('gender') == 'female' ? 'selected' : ''); ?> value="female"> Female</option>
                            </select>
                            <div class="invalid-feedback">Please select your gender!</div>
                            <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert-danger text-danger "><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-lg-6">
                            <input type="email" name="email" placeholder="Email*" value="<?php echo e(old('email')); ?>" required>
                            <div class="invalid-feedback">Please enter your email!</div>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert-danger text-danger "><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <div class="row ">
                                <div class="col-4">
                                    <select name="day" class="form-select" required>
                                        <option value="" disabled selected>Day</option>
                                        <?php for($i = 1; $i <= 31; $i++): ?> <option value="<?php echo e($i); ?>" <?php echo e(old('day') == $i ? 'selected' : ''); ?>><?php echo e($i); ?></option><?php endfor; ?>
                                    </select>
                                    <div class="invalid-feedback">Please select the day!</div>
                                    <?php $__errorArgs = ['day'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="alert-danger text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-4">
                                    <select name="month" class="form-select" required>
                                        <option value="" disabled selected>Month</option>
                                        <?php for($i = 1; $i <= 12; $i++): ?> <option value="<?php echo e($i); ?>" <?php echo e(old('month') == $i ? 'selected' : ''); ?>><?php echo e(date('F', mktime(0, 0, 0, $i, 1))); ?></option>
                                            <?php endfor; ?>
                                    </select>
                                    <div class="invalid-feedback">Please select the month!</div>
                                    <?php $__errorArgs = ['month'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="alert-danger text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-4">
                                    <select name="year" class="form-select" required>
                                        <option value="" disabled selected>Year</option>
                                        <?php for($i = 2006; $i >= 1900; $i--): ?>
                                        <option value="<?php echo e($i); ?>" <?php echo e(old('year') == $i ? 'selected' : ''); ?>><?php echo e($i); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <div class="invalid-feedback">Please select the year!</div>
                                    <?php $__errorArgs = ['year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="alert-danger text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>


                            <div class="mt-0">
                                <p style="color: #3d7de8 ;">* Make a strong password</p>
                            </div>
                            <input type="password" name="password" placeholder="Password*" value="<?php echo e(old('password')); ?>" required>
                            <input type="password" name="password_confirmation" placeholder="Password*" value="<?php echo e(old('password')); ?>" required>
                            <div class="invalid-feedback">Please enter your password!</div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert-danger text-danger "><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-12">
                            <div class="mb-1 small px-1">
                                <p style="color: #3d7de8 ;">* We need to verify your identity before providing treatments. Please use your home address below. You can add a different shipping address at the checkout.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="zip_code" placeholder="Postal Code" value="<?php echo e(old('zip_code')); ?>" required>
                            <div class="invalid-feedback">Please enter your postal code!</div>
                            <?php $__errorArgs = ['zip_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert-danger text-danger "><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="city" placeholder="city" value="<?php echo e(old('city')); ?>" required>
                            <div class="invalid-feedback">Please enter your city!</div>
                            <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert-danger text-danger "><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="address" placeholder="address" value="<?php echo e(old('address')); ?>" required>
                            <div class="invalid-feedback">Please enter your address!</div>
                            <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert-danger text-danger "><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="apartment" placeholder="apartment, suite, etc(optional)" value="<?php echo e(old('address')); ?>">

                            <?php $__errorArgs = ['apartment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert-danger text-danger "><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="mb-1 small px-1">
                                <h3 style="color: #3d7de8; margin-bottom: 5px;">Identity Verification</h3>
                                <p style="color: #3d7de8 ;">
                                    Due to new regulatory policies, you are now required to upload one of the following documents below you will only have to do this once to verify you are the person who is placing the order today.
                                </p>
                                <p style="color: #00c4a3; font-weight:bolder;">Accepted Documentation:</p>
                                <p style="color: #3d7de8;">Please upload one of the following documents, by doing so we will verify these documents with 3rd party agencies to validate you.</p>
                                <ul style="color: #3d7de8; font-weight:bolder; padding-left:2.3rem; margin-top:0rem !important; ">
                                    <li style="margin-top:0.1rem !important; ">Birth Certificate</li>
                                    <li style="margin-top:0.1rem !important; ">Full / Provisional Driving License</li>
                                    <li style="margin-top:0.1rem !important; ">UK / EU Passport</li>
                                </ul>
                            </div>
                            <input class="form-control bg-white " type="file" name="id_document" id="id_document" required>
                            <?php $__errorArgs = ['id_document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert-danger text-danger "><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class=" px-3 mb-2">
                            <button class="theme-btn-1 btn reverse-color btn-block text-center px-3" type="submit">CREATE ACCOUNT</button>
                        </div>
                        <div class="by-agree">
                            <p>By creating an account, you agree to our:</p>
                            <p><a href="/terms_and_conditions/">TERMS OF CONDITIONS &nbsp; &nbsp; | &nbsp; &nbsp; PRIVACY POLICY</a></p>
                            <div class="go-to-btn mt-25">
                                <a href="/admin"><strong>ALREADY HAVE AN ACCOUNT?</strong></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- LOGIN AREA END -->

<?php $__env->stopSection(); ?>

<?php if (! $__env->hasRenderedOnce('3cb99849-155c-4309-8c16-470af4147336')): $__env->markAsRenderedOnce('3cb99849-155c-4309-8c16-470af4147336');
$__env->startPush('scripts'); ?>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

<!-- Script to initialize the datepicker -->

</script>


<?php $__env->stopPush(); endif; ?>

<?php echo $__env->make('web.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\OP-Phill\resources\views/web/pages/registration_form.blade.php ENDPATH**/ ?>