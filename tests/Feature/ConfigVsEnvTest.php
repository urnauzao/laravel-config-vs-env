<?php

namespace Tests\Feature;

use Exception;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

# php artisan test --filter=ConfigVsEnvTest
class ConfigVsEnvTest extends TestCase
{
    const min_key = 0;
    const max_key = 288;
    const config_key = "cacheorenv.key_test";
    const env_key = "KEY_TEST";
    const interations = 50;
    const optimize = true;

    // public function test_clear_cache()
    // {
    //     $result = Artisan::call('optimize:clear');
    //     $this->assertEquals(0, $result);
    // }

    # php artisan test --filter=ConfigVsEnvTest::test_access_env
    public function test_access_env()
    {
        dump(__FUNCTION__);
        if(self::optimize){
            $result = Artisan::call('optimize:clear');
            $this->assertEquals(0, $result);
        }else{
            $result = Artisan::call('config:clear');
            $this->assertEquals(0, $result);
            $result = Artisan::call('cache:clear');
            $this->assertEquals(0, $result);
        }
        $key1 = self::env_key.rand(self::min_key, self::max_key);
        $key2 = self::env_key.rand(self::min_key, self::max_key);
        $key3 = self::env_key.rand(self::min_key, self::max_key);
        $key4 = self::env_key.rand(self::min_key, self::max_key);
        $key5 = self::env_key.rand(self::min_key, self::max_key);
        $key6 = self::env_key."".self::max_key;

        $result =Benchmark::measure([
            'key1' => function() use ($key1){ if(is_null(env($key1, null))) {dump($key1, env($key1, null) );throw new Exception("valor vazio!");}},
            'key2' => function() use ($key2){ if(is_null(env($key2, null))) throw new Exception("valor vazio!");},
            'key3' => function() use ($key3){ if(is_null(env($key3, null))) throw new Exception("valor vazio!");},
            'key4' => function() use ($key4){ if(is_null(env($key4, null))) throw new Exception("valor vazio!");},
            'key5' => function() use ($key5){ if(is_null(env($key5, null))) throw new Exception("valor vazio!");},
            'key6' => function() use ($key6){ if(is_null(env($key6, null))) throw new Exception("valor vazio!");},
        ], self::interations);
        dump($result);
        dump([
            "KEY_TEST0" => env("KEY_TEST0", null),
            $key1 => env($key1, null)
        ]);
        dump("=-=-=-=-=-=-=-=-=");
        dump("=-=-=-=-=-=-=-=-=");
    }

    # php artisan test --filter=ConfigVsEnvTest::test_access_config
    public function test_access_config()
    {
        dump(__FUNCTION__);
        if(self::optimize){
            $result = Artisan::call('optimize:clear');
            $this->assertEquals(0, $result);
        }else{
            $result = Artisan::call('config:clear');
            $this->assertEquals(0, $result);
        }
        
        $key1 = self::config_key.rand(self::min_key, self::max_key);
        $key2 = self::config_key.rand(self::min_key, self::max_key);
        $key3 = self::config_key.rand(self::min_key, self::max_key);
        $key4 = self::config_key.rand(self::min_key, self::max_key);
        $key5 = self::config_key.rand(self::min_key, self::max_key);
        $key6 = self::config_key."".self::max_key;

        $result =Benchmark::measure([
            'key1' => function() use($key1){ if(is_null(config($key1, null))){ throw new Exception("valor vazio!");}},
            'key2' => function() use($key2){ if(is_null(config($key2, null))){ throw new Exception("valor vazio!");}},
            'key3' => function() use($key3){ if(is_null(config($key3, null))){ throw new Exception("valor vazio!");}},
            'key4' => function() use($key4){ if(is_null(config($key4, null))){ throw new Exception("valor vazio!");}},
            'key5' => function() use($key5){ if(is_null(config($key5, null))){ throw new Exception("valor vazio!");}},
            'key6' => function() use($key6){ if(is_null(config($key6, null))){ throw new Exception("valor vazio!");}},
        ], self::interations);
        dump($result);
        dump([
            "cacheorenv.key_test0" => config("cacheorenv.key_test0", null),
            $key1 => config($key1, null)
        ]);
        dump("=-=-=-=-=-=-=-=-=");
        dump("=-=-=-=-=-=-=-=-=");
    }

    # php artisan test --filter=ConfigVsEnvTest::test_access_config_cached
    public function test_access_config_cached()
    {
        dump(__FUNCTION__);
        if(self::optimize){
            $result = Artisan::call('optimize:clear');
            $this->assertEquals(0, $result);
            $result = Artisan::call('optimize');
            $this->assertEquals(0, $result);
        }else{
            $result = Artisan::call('config:clear');
            $this->assertEquals(0, $result);
            $result = Artisan::call('config:cache');
            $this->assertEquals(0, $result);
        }
        $key1 = self::config_key.rand(self::min_key, self::max_key);
        $key2 = self::config_key.rand(self::min_key, self::max_key);
        $key3 = self::config_key.rand(self::min_key, self::max_key);
        $key4 = self::config_key.rand(self::min_key, self::max_key);
        $key5 = self::config_key.rand(self::min_key, self::max_key);
        $key6 = self::config_key."".self::max_key;

        $result =Benchmark::measure([
            'key1' => function() use($key1){ if(is_null(config($key1, null))){ throw new Exception("valor vazio!");}},
            'key2' => function() use($key2){ if(is_null(config($key2, null))){ throw new Exception("valor vazio!");}},
            'key3' => function() use($key3){ if(is_null(config($key3, null))){ throw new Exception("valor vazio!");}},
            'key4' => function() use($key4){ if(is_null(config($key4, null))){ throw new Exception("valor vazio!");}},
            'key5' => function() use($key5){ if(is_null(config($key5, null))){ throw new Exception("valor vazio!");}},
            'key6' => function() use($key6){ if(is_null(config($key6, null))){ throw new Exception("valor vazio!");}},
        ], self::interations);
        dump($result);
        dump([
            "cacheorenv.key_test0" => config("cacheorenv.key_test0", null),
            $key1 => config($key1, null)
        ]);
        dump("=-=-=-=-=-=-=-=-=");
        dump("=-=-=-=-=-=-=-=-=");
    }

}

