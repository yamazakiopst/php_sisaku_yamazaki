<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //半角数字_ハイフン
        Validator::extend('half_num_hyphen', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[0-9-]+$/', $value);
        });

        //半角英数字
        Validator::extend('half_alpha_num', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z0-9]+$/', $value);
        });

        //正数
        Validator::extend('positive_number', function ($attribute, $value, $parameters, $validator) {
            return is_numeric($value) && $value >= 0;
        });

        //桁数_一致_N
        Validator::extend('length_match', function ($attribute, $value, $parameters, $validator) {
            return mb_strlen($value) === intval($parameters[0]);
        });

        //出力メッセージに桁数を埋め込む
        Validator::replacer('length_match', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':n', intval($parameters[0]), $message);
        });

        //桁数_N以下
        Validator::extend('length_less', function ($attribute, $value, $parameters, $validator) {
            return mb_strlen($value) <= intval($parameters[0]) && mb_strlen($value) >= 1;
        });

        //出力メッセージに桁数を埋め込む
        Validator::replacer('length_less', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':n', intval($parameters[0]), $message);
        });

        //郵便番号
        Validator::extend('zip', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[0-9]{3}-[0-9]{4}$/', $value);
        });

        //整合性_上限下限
        Validator::extend('greater_than_field', function ($attribute, $value, $parameters, $validator) {
            $min_field = $parameters[0];
            $data = $validator->getData();
            //リクエストパラメータ（下限）の存在確認
            if (!array_key_exists($min_field, $data) || $data[$min_field] === null) {
                return true;
            }
            $min_value = $data[$min_field];
            return $value >= $min_value;
        });

        //出力メッセージに比較フィールド名を埋め込む
        Validator::replacer('greater_than_field', function ($message, $attribute, $rule, $parameters) {
            $fieldName = $parameters[0];
            $attributes =  trans('validation.attributes');
            if (array_key_exists($fieldName, $attributes)) {
                $fieldName = $attributes[$fieldName];
            }
            return str_replace(':field', $fieldName, $message);
        });

        //整合性_上限下限
        Validator::extend('less_than_field', function ($attribute, $value, $parameters, $validator) {
            $max_field = $parameters[0];
            $data = $validator->getData();
            //リクエストパラメータ（上限）の存在確認
            if (!array_key_exists($max_field, $data) || $data[$max_field] === null) {
                return true;
            }
            $max_value = $data[$max_field];
            return $value <= $max_value;
        });

        //出力メッセージに比較フィールド名を埋め込む
        Validator::replacer('less_than_field', function ($message, $attribute, $rule, $parameters) {
            $fieldName = $parameters[0];
            $attributes =  trans('validation.attributes');
            if (array_key_exists($fieldName, $attributes)) {
                $fieldName = $attributes[$fieldName];
            }
            return str_replace(':field', $fieldName, $message);
        });
    }
}
