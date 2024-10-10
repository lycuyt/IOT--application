<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\MqttClient;

class MqttListener extends Command
{
    
    protected $signature = 'mqtt:listen';
    protected $description = 'Listen to MQTT messages and store them in the database';

    public function handle()
    {
        $server = '192.168.0.103'; // Địa chỉ IP của MQTT broker
        $port = 1993; // Cổng MQTT
        $clientId = 'mqtt_client';

        // Kết nối với MQTT broker
        $client = new MqttClient($server, $port, $clientId);
        $connectionSettings = (new ConnectionSettings)
            ->setUsername('ly')
            ->setPassword('123');

        $client->connect($connectionSettings, true);
        
        // Đăng ký chủ đề để nhận dữ liệu
        $client->subscribe('sensor/data', function (string $topic, string $message) {
            // Tách dữ liệu
            list($temperature, $humidity, $light) = explode(',', $message);

            // Lưu vào cơ sở dữ liệu
            DB::table('datas')->insert([
                'temperature' => $temperature,
                'humidity' => $humidity,
                'light' => $light,
                'time' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
        // $client->subscribe('device/log', function (string $topic, string $message) {
        //     $this->info("Received message from MQTT topic {$topic}: {$message}");
        //     // Split the message into device and action
        //     list($device, $action) = explode(',', $message);
        
        //     // Log the action into the database
        //     DB::table('actions')->insert([
        //         'device' => $device,
        //         'action' => $action,
        //         'time'=> now(),
        //         'user_id' => 1, 
        //         'timestamp' => now(),
        //     ]);
        // });
       
        $this->info('Listening for MQTT messages...');

        // Chạy vòng lặp để lắng nghe dữ liệu
        while (true) {
            // $client->loop();
            // sleep(1); // Chờ 1 giây trước khi lặp lại
            $client->loop(true, true); 
        }
    }
}