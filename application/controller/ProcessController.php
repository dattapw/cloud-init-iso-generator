<?php


namespace DattaConsulting\CloudInitIso\Controller;


use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;

class ProcessController
{
    public function index() {

        try{

            $os_password = $_POST['os_password'];
            $ssh_login = $_POST['ssh_login'];
            $ssh_keys = $_POST['ssh_public_key'];
            $instance_id = $_POST['instance_id'];
            $os_hostname = $_POST['os_hostname'];

            $user_data = [];
            $meta_data = [];

            $meta_data['instance-id'] = $instance_id;
            $meta_data['local-hostname'] = $os_hostname;

            $user_data['password'] = $os_password;
            $user_data['chpasswd'] = ['expire' => false];
            $user_data['ssh_pwauth'] = $ssh_login;
            $user_data['ssh_authorized_keys'] = $ssh_keys;

            $user_data_yaml = "#cloud-config\n".Yaml::dump($user_data);
            $meta_data_yaml = Yaml::dump($meta_data);

            $session_dir = time()."-".mt_rand(0,10000000000);

            mkdir(dirname(__FILE__)."/../data/".$session_dir);

            file_put_contents(dirname(__FILE__)."/../data/".$session_dir."/user-data", $user_data_yaml);
            file_put_contents(dirname(__FILE__)."/../data/".$session_dir."/meta-data", $meta_data_yaml);

            //'/usr/bin/genisoimage -output seed.iso -volid cidata -joliet -rock user-data meta-data'

            $process = Process::fromShellCommandline(
                '/usr/bin/genisoimage -output seed.iso -volid cidata -joliet -rock user-data meta-data',
                dirname(__FILE__)."/../data/".$session_dir
            );

            $process->mustRun();

            header('Content-type: application/zip'); //this could be a different header
            header('Content-Disposition: attachment; filename="seed.iso"');

            ignore_user_abort(true);

            $context = stream_context_create();
            $file = fopen(dirname(__FILE__)."/../data/".$session_dir."/seed.iso", 'rb', FALSE, $context);
            while(!feof($file))
            {
                echo stream_get_contents($file, 2014);
            }
            fclose($file);
            flush();
            if (file_exists(dirname(__FILE__)."/../data/".$session_dir."/seed.iso")) {
                unlink( dirname(__FILE__)."/../data/".$session_dir."/seed.iso" );
                unlink( dirname(__FILE__)."/../data/".$session_dir."/user-data" );
                unlink( dirname(__FILE__)."/../data/".$session_dir."/meta-data" );
                rmdir(dirname(__FILE__)."/../data/".$session_dir);
            }

        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }
}
