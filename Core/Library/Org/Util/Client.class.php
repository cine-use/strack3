<?php
/**
 * Created by PhpStorm.
 * User: alpha
 * Date: 2018/8/22
 * Time: 16:58
 */

namespace Org\Util;

/**
 * cllapse MacAddress to LicenseClient.php
 * cllapse KeyGenerator to LicenseClient.php
 * copy LicenseClient from LicenseClient.php
 *      //remove privateKey part
 *      //remove privateEncrypt/privateDecrypt/genSecretKeyPair/$privateKey/$PRIVATE_KEY_BITE
 * */
class Client
{
    // 错误码
    public $errorCode = 0;

    // 错误信息
    public $errorMessage = 0;

    // 当前验证lic数据
    public $licenseInfoData = [];


    // ================================== MacAddress  ==============================================================
    private static $valid_mac_regx = "([0-9A-F]{2}[:-]){5}([0-9A-F]{2})";

    protected static function runCommand($command)
    {
        return shell_exec($command);
    }

    public static function getCurrentMacAddress($interface = "")
    {
        $ifconfig = self::runCommand("ifconfig {$interface}");
        preg_match("/" . self::$valid_mac_regx . "/i", $ifconfig, $ifconfig);
        if (isset($ifconfig[0])) {
            return trim(strtoupper($ifconfig[0]));
        }
        return false;
    }

    // ==================================KeyGenerator ==============================================================
    // KeyGenerator vars
    /*split to blocks to let ssl work*/
    // encrypt split length
    private $ENCRYPT_SPLIT_LENGTH = 117;
    // decrypt split length
    private $DECRYPT_SPLIT_LENGTH = 128;

    // save public key;
    private $publicKey = '';


    //LicenseClient funcs
    // set privateKey with base64_encoded string
    public function setPublicKeyWithBase64Encoded($base64_encoded_public_key)
    {
        $this->publicKey = base64_decode($base64_encoded_public_key);
    }

    public function getPublicKey($base64_encode = false)
    {
        if ($base64_encode) {
            return base64_encode($this->publicKey);
        }
        return $this->publicKey;
    }

    public function publicEncrypt($originData)
    {
        $encrypted = '';
        foreach (str_split($originData, $this->ENCRYPT_SPLIT_LENGTH) as $chunk) {
            openssl_public_encrypt($chunk, $encrypted_section, $this->publicKey);
            $encrypted .= $encrypted_section;
        }
        return $encrypted;
    }

    public function publicDecrypt($encrypted)
    {
        $decrypted = '';
        foreach (str_split($encrypted, $this->DECRYPT_SPLIT_LENGTH) as $chunk) {
            openssl_public_decrypt($chunk, $decrypted_section, $this->publicKey);
            $decrypted .= $decrypted_section;
        }
        return $decrypted;
    }



    // LicenseClient vars
    // These keys will replaced in CI progress. so they are unique in each company and each version release package
    private $KeyPairBase64EncodePublicA = 'LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0KTUlHZk1BMEdDU3FHU0liM0RRRUJBUVVBQTRHTkFEQ0JpUUtCZ1FDVWtOZ2t2dVBWNU9Ba3BWcWdXbDVxRVlNUQpXN3FmcDV2TkVYR3VvRlI1eE9LcVZoZTBXUkVhOGdxdTBXZy9teklrbVdDR21lVXRyek1uZXNGSU9zTStNSFNxCmxnSjVoY1g2NWFhSzJ1QUEzbENmeFJKV2JWalVtdnV0ME1wTDFuU2J1cnlmRUx3Z3MxQk1hOFNEeXNCT0pxUGEKUmhuY05YRStlei9adDlCNHJRSURBUUFCCi0tLS0tRU5EIFBVQkxJQyBLRVktLS0tLQo';
    private $KeyPairBase64EncodePublicB = '$KeyPairPublicB';
    private $KeyPairBase64EncodePublicC = '$KeyPairPublicC';


    private $activationStruct = [
        'companyInfos' => [
            'companyName' => 'CineuseInternal'
        ],
        'hardwareInfos' => [
        ],
        'softwareInfos' => [
            'productName' => 'Strack3',
            'version' => 'v0.0.1',
            'oem' => 'standard',
            'gitCommitHash' => '1f290b6fae9411112d1f8056a673d57c196c637b',
            'filesIntegrityCheckList' => []
        ]
    ];
    private $parser;

    private $errorList = [];

    public function __construct()
    {
        //init linfo
        $linfo = new \Linfo\Linfo();
        $this->parser = $linfo->getParser();

        //set hardware infos
        $this->activationStruct = [
            'companyInfos' => [
                'companyName' => $this->activationStruct['companyInfos']['companyName']
            ],
            'hardwareInfos' => [
                // todo , ensure the mac is ok when has multi mac
                'mac' => $this->getMacAddress(),
                // todo , ensure the ip is ok when has multi ip
                'ip' => $this->parser->getAccessedIP(),
                'port' => $_SERVER['SERVER_PORT'],
                'hostName' => $this->parser->getHostName(),
                'cpuInfos' => $this->getCPU(),
                // =>  "x86_64"
                'cpuArch' => $this->parser->getCPUArchitecture(),
                //is virtual machine or docker => ["type" =>"guest", "method" => "Docker"]
                'virtual' => $this->parser->getVirtualization(),
                'devices' => $this->parser->getDevs(),
                //linux kernel => 3.10.0-862.9.1.el7.x86_64
                'kernel' => $this->parser->getKernel(),
                //mother board type => "Micro-Star International Co., Ltd. H310M FIRE (MS-7B33)"
                'model' => $this->parser->getModel(),
                'hd' => $this->getHD(),
                'ram' => $this->getRam(),
                'netCards' => $this->getNetCardInfos(),
            ],
            'softwareInfos' => [
                // activation generate
                'datetime' => $this->getDatetime(),
                'timezone' => date_default_timezone_get(),
                // fill in linux env infos
                'osInfos' => [
                    'systemOS' => $this->parser->getOS()
                ],
                'phpInfos' => [
                    'phpVers' => $this->parser->getOS(),
                    'documentRoot' => $this->getDocumentRoot(),
                    'distro' => $this->parser->getDistro()
                ],
                // set software infos , CI will do these .
                'productName' => $this->activationStruct['softwareInfos']['productName'],
                'version' => $this->activationStruct['softwareInfos']['version'],
                'requiredModules' => [],
                'oem' => $this->activationStruct['softwareInfos']['oem'],
                'gitCommitHash' => $this->activationStruct['softwareInfos']['gitCommitHash'],
                'keys' => [
                    'KeyPairPublicA' => $this->KeyPairBase64EncodePublicA,
                    'KeyPairPublicB' => $this->KeyPairBase64EncodePublicB,
                    'KeyPairPublicC' => $this->KeyPairBase64EncodePublicC
                ],
                'filesIntegrityCheckList' => $this->activationStruct['softwareInfos']['filesIntegrityCheckList']
            ]
        ];

        //init keys in file
        $this->setPublicKeyWithBase64Encoded($this->KeyPairBase64EncodePublicA);
    }

    /**
     *****************************************************
     * get machine infos
     *****************************************************
     * */
    private function getMacAddress()
    {
        return strtolower(self::getCurrentMacAddress());
    }


    private function getDocumentRoot()
    {
        return $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     *   =>
     *       array(3) {
     *           ["count"] => int(6)
     *           ["vendor"] => string(12) "GenuineIntel"
     *           ["model"] => string(39) "Intel(R) Core(TM) i5-8400 CPU @ 2.80GHz"
     *       }
     */
    private function getCPU()
    {
        $_infos = $this->parser->getCPU();
        $infos = [
            'count' => count($_infos),
            'vendor' => $_infos[0]['Vendor'],
            'model' => $_infos[0]['Model']
        ];
        return $infos;
    }

    /**
     *  =>
     *    array(2) {
     *      [0] => array(4) {
     *          ["name"] => string(20) "tigo SSD 240GB (SSD)"
     *          ["vendor"] => string(3) "ATA"
     *          ["device"] => string(8) "/dev/sda"
     *          ["size"] => int(240057409536)*
     *      }
     *      [1] => array(4) {
     *          ["name"] => string(16) "ST4000NM0035-1V4"
     *          ["vendor"] => string(3) "ATA"
     *          ["device"] => string(8) "/dev/sdb"
     *          ["size"] => int(4000787030016)
     *      }
     *   }
     */
    private function getHD()
    {
        $_infos = $this->parser->getHD();
        $infos = [];
        foreach ($_infos as $key => $value) {
            $infos[$key] = [
                'name' => $value['name'],
                'vendor' => $value['vendor'],
                'device' => $value['device'],
                'size' => $value['size']
            ];
        }

        return $infos;
    }

    /**
     * =>       ["type"] => string(8) "Physical"
     *          ["total"] => int(33432719360) //disk size
     * */
    private function getRam()
    {
        $_infos = $this->parser->getRam();
        $infos = [
            'type' => $_infos['type'],
            'total' => $_infos['total']
        ];
        return $infos;
    }

    /**
     * get netcards name
     *  =>   [0] => string(4) "eth0"
     *       [1] => string(2) "lo"
     * */
    private function getNetCardInfos()
    {
        $_infos = $this->parser->getNet();
        return array_keys($_infos);
    }

    private function wrapActivation($activationKeyEncoded)
    {
        $productName = $this->activationStruct['softwareInfos']['productName'];
        $productVersion = $this->activationStruct['softwareInfos']['version'];
        $productBrand = strtoupper($productName) . ' ' . strtoupper($productVersion);
        $wrapHeader = str_replace('PUBLIC', $productBrand, '-----BEGIN PUBLIC ACTIVATION KEY-----' . ' ');
        $wrapFooter = str_replace('PUBLIC', $productBrand, ' ' . '-----END PUBLIC ACTIVATION KEY-----');

        return $wrapHeader . $activationKeyEncoded . $wrapFooter;
    }

    private function setupRequiredModules($requiredModuleArray)
    {
        $this->activationStruct['softwareInfos']['requiredModules'] = $requiredModuleArray;
    }

    public function generateActivationKey($requiredModuleArray)
    {
        $this->setupRequiredModules($requiredModuleArray);
        $activationKeyEncoded = base64_encode(serialize(
            [
                'publicKey' => $this->KeyPairBase64EncodePublicA,
                'activationKey' => $this->publicEncrypt(serialize($this->activationStruct))
            ]
        ));

        return $this->wrapActivation($activationKeyEncoded);
    }

    private function getDatetime()
    {
        $mtimestamp = sprintf("%.3f", microtime(true));
        $timestamp = floor($mtimestamp);
        $milliseconds = round(($mtimestamp - $timestamp) * 1000);
        $datetime = date("Y-m-d H:i:s", $timestamp) . ' . ' . $milliseconds;
        return $datetime;
    }

    private function unwarpLicense($licenseKeyWraped)
    {
        $productName = $this->activationStruct['softwareInfos']['productName'];
        $productVersion = $this->activationStruct['softwareInfos']['version'];
        $productBrand = strtoupper($productName) . ' ' . strtoupper($productVersion);
        $wrapHeader = str_replace('PUBLIC', $productBrand, '-----BEGIN PUBLIC LICENSE KEY-----' . ' ');
        $wrapFooter = str_replace('PUBLIC', $productBrand, ' ' . '-----END PUBLIC LICENSE KEY-----');
        //remove header
        $_licenseKeyWraped = str_replace($wrapHeader, '', $licenseKeyWraped);
        $finalLicenseKey = str_replace($wrapFooter, '', $_licenseKeyWraped);
        //remove footer
        return $finalLicenseKey;
    }


    /**
     * return license data files integrity check
     * @param $licenseKeyWrapped
     * @return mixed
     */
    private function getLicenseKeyData($licenseKeyWrapped)
    {
        try {
            $licenseKeyUnwrapped = $this->unwarpLicense($licenseKeyWrapped);
            $base64_decode_string = base64_decode($licenseKeyUnwrapped);
            $serialize_license_array = $this->publicDecrypt($base64_decode_string);
            return unserialize($serialize_license_array);
        } catch (\Exception $e) {
            return '';
        }
    }


    /**
     * files integrity check , true is ok and false is failed
     * @param $filesIntegrityCheckList
     * @return bool
     */
    private function checkFilesIntegrity($filesIntegrityCheckList)
    {
        foreach ($filesIntegrityCheckList as $filePath => $fileMd5) {
            $computed_md5 = md5_file($filePath);
            if ($computed_md5 != $fileMd5) {
                $this->updateErrorList($filePath, [$computed_md5, '-- should be--> ', $fileMd5]);
                return false;
            }
        }
        return true;
    }

    private function updateErrorList($errorKey, $errorValue)
    {
        $this->errorList += [[$errorKey, $errorValue]];
    }

    private function makeValidateInfos($localInfoCheckPassed, $licenseArrayOrErrorArray = [])
    {
        if ($licenseArrayOrErrorArray == []) {
            return [
                'localInfoCheckPassed' => $localInfoCheckPassed,
                'licenseArrayOrErrorArray' => $this->errorList
            ];
        } else {
            return [
                'localInfoCheckPassed' => $localInfoCheckPassed,
                'licenseArrayOrErrorArray' => $licenseArrayOrErrorArray
            ];
        }
    }

    private function licenseValidate($licenseStruct)
    {
        $companyInfos = $licenseStruct['companyInfos'];
        $hardwareInfos = $licenseStruct['hardwareInfos'];
        $softwareInfos = $licenseStruct['softwareInfos'];

        // 1 check company infos
        $companyInfosCompareList = [
            [$companyInfos['companyName'], $this->activationStruct['companyInfos']['companyName']]
        ];

        foreach ($companyInfosCompareList as $companyInfoKey => $companyInfoValue) {
            list($licCompanyInfoValue, $localCompanyInfoValue) = $companyInfoValue;
            if ($licCompanyInfoValue != $localCompanyInfoValue) {
                $this->updateErrorList($licCompanyInfoValue, $localCompanyInfoValue);
                return $this->makeValidateInfos(false);
            }
        }

        // 2 check hardware infos
        $hardwareInfosCompareList = [
            [$hardwareInfos['mac'], $this->getMacAddress()],
            [$hardwareInfos['ip'], $this->parser->getAccessedIP()],
            [$hardwareInfos['port'], $_SERVER['SERVER_PORT']],
            [$hardwareInfos['hostName'], $this->parser->getHostName()],
            // [cpuCount,vendorName,cpuType]
            [$hardwareInfos['cpuInfos'], $this->getCPU()],
            // =>  "x86_64"
            [$hardwareInfos['cpuArch'], $this->parser->getCPUArchitecture()],
            //is virtual machine or docker => ["type" =>"guest", "method" => "Docker"]
            [$hardwareInfos['virtual'], $this->parser->getVirtualization()],
            [$hardwareInfos['devices'], $this->parser->getDevs()],
            //linux kernel => 3.10.0-862.9.1.el7.x86_64
            [$hardwareInfos['kernel'], $this->parser->getKernel()],
            //mother board type => "Micro-Star International Co., Ltd. H310M FIRE (MS-7B33)"
            [$hardwareInfos['model'], $this->parser->getModel()],
            //hd info , [...]
            [$hardwareInfos['hd'], $this->getHD()],
            //ram info , [...]
            [$hardwareInfos['ram'], $this->getRam()],
            //netcards info , [...]
            [$hardwareInfos['netCards'], $this->getNetCardInfos()],
        ];

        foreach ($hardwareInfosCompareList as $hardwareInfoKey => $hardwareInfoValue) {
            list($licHardwareInfoValue, $localHardwareInfoValue) = $hardwareInfoValue;
            if ($licHardwareInfoValue != $localHardwareInfoValue) {
                $this->updateErrorList($licHardwareInfoValue, $localHardwareInfoValue);
                return $this->makeValidateInfos(false);
            }
        }

        // 3 check hardware infos
        $softwareInfosCompareList = [
            [$softwareInfos['timezone'], date_default_timezone_get()],
            [$softwareInfos['osInfos'], $this->activationStruct['softwareInfos']['osInfos']],
            [$softwareInfos['phpInfos'], $this->activationStruct['softwareInfos']['phpInfos']],
            [$softwareInfos['productName'], $this->activationStruct['softwareInfos']['productName']],
            [$softwareInfos['version'], $this->activationStruct['softwareInfos']['version']],
            [$softwareInfos['oem'], $this->activationStruct['softwareInfos']['oem']],
            [$softwareInfos['keys'], $this->activationStruct['softwareInfos']['keys']],
        ];

        foreach ($softwareInfosCompareList as $softwareInfoKey => $softwareInfoValue) {
            list($licSoftwareInfoValue, $localSoftwareInfoValue) = $softwareInfoValue;
            if ($licSoftwareInfoValue != $localSoftwareInfoValue) {
                $this->updateErrorList($licSoftwareInfoValue, $localSoftwareInfoValue);
                return $this->makeValidateInfos(false);
            }
        }

        // 4 files integrity
        $filesIntegrityOk = $this->checkFilesIntegrity($softwareInfos['filesIntegrityCheckList']);
        if (!$filesIntegrityOk) {
            return $this->makeValidateInfos(false);
        }
        return $this->makeValidateInfos(true, $softwareInfos['licenseInfos']);
    }

    public function getLicenseInfosValidated($licenseKeyDataWrapped)
    {
        $clientLicenseKeyArray = $this->getLicenseKeyData($licenseKeyDataWrapped);
        if (!empty($clientLicenseKeyArray)) {
            return $this->licenseValidate($clientLicenseKeyArray);
        } else {
            return $this->makeValidateInfos(false);
        }
    }

    /**
     * 验证许可
     * @param $licenseString
     * @param $currentUserNumber
     * @return bool
     */
    public function validate($licenseString, $currentUserNumber)
    {
        $flag = false;
        $this->licenseInfoData["current_number"] = $currentUserNumber;
        $licenseData = $this->getLicenseInfosValidated($licenseString);
        if ($licenseData["localInfoCheckPassed"] === true) {
            // 判断到期时间
            $licenceDate = strtotime($licenseData["licenseArrayOrErrorArray"]["expire_date"]);
            // 过期时间为第二天凌晨
            $overdueTime = $licenceDate + 86400;
            // 当前时间戳
            $currentTime = strtotime(date('Y-m-d' . '00:00:00', time()));

            $this->licenseInfoData["license_number"] = $licenseData["licenseArrayOrErrorArray"]["user_number"];

            if ($currentTime >= $overdueTime) {
                $flag = false;
                $this->errorCode = 208003;
                $this->errorMessage = L("License_Format_Error");
            } else if ($currentUserNumber > $licenseData["licenseArrayOrErrorArray"]["user_number"]) {
                $flag = false;
                $this->errorCode = 208004;
                $this->errorMessage = L("User_Number_Greater_License");
            } else {
                $flag = true;
            }

        } else {
            $this->errorCode = 208003;
            $this->errorMessage = L("License_Format_Error");
        }
        return $flag;
    }
}