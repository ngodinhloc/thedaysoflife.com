<div class="row no-front col-md-6 col-md-offset-2">
    <form role="form" method="post" action="/back/login/">
        <fieldset>
            <legend>Adminitration Login:</legend>
            <div class="col-md-12 form-contact form-group">
                <?php if (isset($this->data["message"])) { ?>
                    <div class="form-group col-xs-12">
                        <b class="error"><?= $this->data["message"] ?></b>
                    </div>
                <?php } ?>
                <div class="form-group col-xs-12">
                    <div class="icon">
                        <label class="email sr-only">Email</label>
                    </div>
                    <input type="email" class="email form-control" name="email" id="email" placeholder="Email">
                </div>
                <div class="form-group col-xs-12">
                    <div class="icon">
                        <label class="website sr-only">Password</label>
                    </div>
                    <input type="password" class="full-name form-control" name="password" id="password"
                           placeholder="Password">
                </div>
                <div class="form-group  col-xs-12">
                    <button type="submit" class="btn btn-primary" id="make-list">Login</button>
                    <span id="ajax-loader" class="error"></span>
                </div>
            </div>
        </fieldset>
    </form>
    <br/><br/>
</div>