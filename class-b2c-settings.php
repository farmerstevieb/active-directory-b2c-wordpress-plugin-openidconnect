<?php

class B2C_Settings {

    // These settings are configurable by the admin
    public static string $tenant_name = ""; // ex: contoso
    public static string $tenant_domain = ""; // ex: contoso.onmicrosoft.com
    public static string $clientID = "";
    public static string $generic_policy = "";
    public static string $admin_policy = "";
    public static string $edit_profile_policy = "";
    public static string $password_reset_policy = "";
    public static string $redirect_uri = "";
    public static int $verify_tokens = 1;

    // These settings define the authentication flow, but are not configurable on the settings page
    // because this plugin is made to support OpenID Connect implicit flow with form post responses
    public static string $response_type = "id_token";//code id_token token
    public static string $response_mode = "form_post";
    public static string $scope = "openid";

    function __construct() {

        // Get the inputs from the B2C Settings Page
        $config_elements = get_option('b2c_config_elements');

        if (isset($config_elements)) {

            // Parse the settings entered in by the admin on the b2c settings page
            self::$tenant_name = $config_elements['b2c_aad_tenant_name'];
            self::$tenant_domain = $config_elements['b2c_aad_tenant_domain'];
            self::$clientID = $config_elements['b2c_client_id'];
            self::$generic_policy = $config_elements['b2c_subscriber_policy_id'];
            self::$admin_policy = $config_elements['b2c_admin_policy_id'];
            self::$edit_profile_policy = $config_elements['b2c_edit_profile_policy_id'];
            self::$password_reset_policy = $config_elements['b2c_password_reset_policy_id'];
            self::$redirect_uri = urlencode(site_url().'/');
            if ($config_elements['b2c_verify_tokens']) self::$verify_tokens = 1;
            else self::$verify_tokens = 0;
        }
    }

    /**
     * @return string
     */
    static function metadata_endpoint_begin(): string
    {
        return 'https://'.self::$tenant_name.'.b2clogin.com/'.self::$tenant_domain.'/v2.0/.well-known/openid-configuration?p=';
    }
}

