<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
       <div class="login-wrap" style="float:left;"><div class="login" id="theme-my-login<?php $template->the_instance(); ?>">
	<p class="message">Register a New Account </p>
	<?php $template->the_errors(); ?>
	<form name="registerform" id="registerform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'register' ); ?>" method="post">
		<p>
			<label for="user_login<?php $template->the_instance(); ?>"><?php _e( 'Username' ); ?> *</label>
			<input type="text" name="user_login" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_login' ); ?>" size="20" />
		</p>

		<p>
			<label for="user_email<?php $template->the_instance(); ?>"><?php _e( 'E-mail' ); ?></label>
			<input type="text" name="user_email" id="user_email<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_email' ); ?>" size="20" />
		</p>

		<?php do_action( 'register_form' ); ?>
<!--
		<p>
			<label for="user_vat_btw_number<?php $template->the_instance(); ?>" ><?php _e( 'VAT / BTW Number:' ); ?></label>
			<input type="text" name="user_vat_btw_number" id="user_vat_btw_number<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_vat_btw_number' ); ?>" size="20" />
		</p>

		<p>
			<label for="user_kvk_number<?php $template->the_instance(); ?>"><?php _e( 'KVK Number:' ); ?></label>
			<input type="text" name="user_kvk_number" id="user_kvk_number<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_kvk_number' ); ?>" size="20" />
		</p>


		<p>
			<label for="user_eori_number<?php $template->the_instance(); ?>"><?php _e( 'EORI Number:' ); ?></label>
			<input type="text" name="user_eori_number" id="user_eori_number<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_eori_number' ); ?>" size="20" />
		</p>
-->
		<p id="reg_passmail<?php $template->the_instance(); ?>"><?php echo apply_filters( 'tml_register_passmail_template_message', __( 'A password will be e-mailed to you.' ) ); ?></p>

		<p class="submit">
			<input type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="<?php esc_attr_e( 'Register' ); ?>" />
			<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'register' ); ?>" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="action" value="register" />
		</p>
	</form>
</div>



</div>


       <div class="login-wrap" style="float:right;">
<div class="login" id="theme-my-login<?php $template->the_instance(); ?>">
	<p class="message">Login</p>

	<?php $template->the_action_template_message( 'login' ); ?>
	<?php $template->the_errors(); ?>
	<form name="loginform" id="loginform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'login' ); ?>" method="post">
		<p>
			<label for="user_login<?php $template->the_instance(); ?>">Username or E-mail</label>
			<input type="text" name="log" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'log' ); ?>" size="20" />
		</p>
		<p>
			<label for="user_pass<?php $template->the_instance(); ?>"><?php _e( 'Password' ); ?></label>
			<input type="password" name="pwd" id="user_pass<?php $template->the_instance(); ?>" class="input" value="" size="20" />
		</p>

		<?php do_action( 'login_form' ); ?>

		<p class="forgetmenot">
			<input name="rememberme" type="checkbox" id="rememberme<?php $template->the_instance(); ?>" value="forever" />
			<label for="rememberme<?php $template->the_instance(); ?>"><?php esc_attr_e( 'Remember Me' ); ?></label>
		</p>
		<p class="submit">
			<input type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="Log In" />
			<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'login' ); ?>" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="action" value="login" />
		</p>
	</form>
	<?php $template->the_action_links( array( 'login' => false ) ); ?>
</div>

</div>
