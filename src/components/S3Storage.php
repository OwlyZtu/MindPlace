<?php

namespace app\components;

use Yii;
use Aws\S3\S3Client;
use yii\base\Component;
use yii\web\UploadedFile;

class S3Storage extends Component
{
    public $key;
    public $secret;
    public $bucket = 'mindplacediploma';
    public $region = 'eu-north-1';
    public $clientConfig;
    private $_client;

    public function getClient()
    {
        if (!$this->_client) {
            if (!$this->key || !$this->secret) {
                Yii::warning('AWS credentials not set properly', 'therapist-join');
                return null;
            }
    
            $this->_client = new S3Client([
                'version' => 'latest',
                'region' => $this->region,
                'credentials' => [
                    'key' => $this->key,
                    'secret' => $this->secret,
                ],
            ]);
        }
    
        return $this->_client;
    }
    

    public function init()
    {
        parent::init();

        // Використовуємо clientConfig, якщо він заданий
        if ($this->clientConfig) {
            $credentials = $this->clientConfig['credentials'] ?? [];
            $this->key = $credentials['key'] ?? $this->key;
            $this->secret = $credentials['secret'] ?? $this->secret;
            $this->region = $this->clientConfig['region'] ?? $this->region;
            Yii::info("S3Storage init: key={$this->key}, secret=" . ($this->secret ? 'set' : 'empty'), 'therapist-join');

        }

        if (!$this->key || !$this->secret) {
            Yii::warning('AWS credentials not set properly', 'therapist-join');
            return;
        }

        $this->_client = new S3Client([
            'version' => 'latest',
            'region' => $this->region,
            'credentials' => [
                'key' => $this->key,
                'secret' => $this->secret,
            ],
        ]);
    }

    public function upload(UploadedFile $file, $directory = 'documents')
    {
        if (!$this->client) {
            return false;
        }

        $fileName = uniqid() . '_' . time() . '.' . $file->extension;
        $filePath = $directory . '/' . $fileName;

        try {
            $this->client->putObject([
                'Bucket' => $this->bucket,
                'Key' => $filePath,
                'Body' => fopen($file->tempName, 'r'),
                'ContentType' => $file->type,
            ]);

            return [
                'name' => $fileName,
                'path' => $filePath,
                'url' => "https://{$this->bucket}.s3.{$this->region}.amazonaws.com/{$filePath}",
            ];
        } catch (\Exception $e) {
            Yii::error('Error uploading to S3: ' . $e->getMessage(), 'therapist-join');
            return false;
        }
    }

    public function delete($filePath)
    {
        if (!$this->client) {
            return false;
        }

        try {
            $this->client->deleteObject([
                'Bucket' => $this->bucket,
                'Key' => $filePath,
            ]);

            return true;
        } catch (\Exception $e) {
            Yii::error('Error deleting from S3: ' . $e->getMessage(), 'therapist-join');
            return false;
        }
    }

    public function testConnection()
    {
        if (!$this->client) {
            Yii::error('S3 client is not initialized', 'therapist-join');
            return false;
        }

        try {
            $this->client->listBuckets();
            return true;
        } catch (\Exception $e) {
            Yii::error('S3 connection test failed: ' . $e->getMessage(), 'therapist-join');
            return false;
        }
    }
}
