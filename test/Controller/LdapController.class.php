<?php

namespace Test\Controller;


use Common\Service\LdapService;
use Common\Service\OptionsService;

class LdapController
{

    public function LoginTest()
    {
        $ldapService = new LdapService();
        $param       = ["login_name" => "maryw",
                        "password"   => "asdf1234."];
        $resData     = $ldapService->LdapUserOperation($param);
        dump($resData);
    }

    public function dnTest()
    {
        $dn          = [
            "dn1" => "CN=group-s,OU=IT,DC=sayms,DC=com",
            "dn2" => "CN=g-users,OU=groups,OU=cineuse,DC=sayms,DC=com",
            "dn3" => "CN=overWatch1,OU=OW,DC=sayms,Dc=com",
        ];
        $ldapService = new  LdapService();
        $param       = $dn["dn3"];
        $resData     = $ldapService->ldapDNConfigTest($param);
        if (!$resData)
        {
            dump($ldapService->getError());
        }else{
            dump($resData);
        }
    }

    public function dnCreateUserTest()
    {
        $dn          = [
            "dn1" => "CN=group-s,OU=IT,DC=sayms,DC=com",
            "dn2" => "CN=g-users,OU=groups,OU=cineuse,DC=sayms,DC=com",
            "dn3" => "CN=overWatch,OU=OW,DC=sayms1,Dc=com1",
        ];
        $ldapService = new LdapService();
        $param       = $dn["dn1"];
        $resData     = $ldapService->createDnAllUser($param);
        dump($resData);
    }

    public function ldapConfig()
    {
        $optionModel = new OptionsService();
        $param       = [
            "config" => [
                "config"   => [
                    'domain_controllers' => ['192.168.31.126'],
                    'base_dn'            => 'DC=sayms,DC=com',
                    'admin_username'     => 'sayms\Administrator',
                    'admin_password'     => 'P@ssw0rd',
                ],
                "dn_config" => [
                    "dn1" => "CN=group-s,OU=IT,DC=sayms,DC=com",
                    "dn2" => "CN=g-users,OU=groups,OU=cineuse,DC=sayms,DC=com",
                ],
                "allowed_login_dn"=>[
                    "CN=group-s,OU=IT,DC=sayms,DC=com",
                    "CN=g-users,OU=groups,OU=cineuse,DC=sayms,DC=com",
                ],
                "login_option"=>false,
            ]
        ];
      $resData=  $optionModel->updateOptionsData("ldap_settings",$param);
      dump($resData);

    }

    public function testLdapConfig()
    {
        $ldapService=  new LdapService();
        $resData=$ldapService->testLdapConfig();
        dump($resData);
    }

}