<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attributeを承認してください。',
    'active_url'           => ':attributeには有効なURLを指定してください。',
    'after'                => ':attributeには:date以降の日付を指定してください。',
    'after_or_equal'       => ':attributeには:dateかそれ以降の日付を指定してください。',
    'alpha'                => ':attributeには英字のみからなる文字列を指定してください。',
    'alpha_dash'           => ':attributeには英数字・ハイフン・アンダースコアのみからなる文字列を指定してください。',
    'alpha_num'            => ':attributeには英数字のみからなる文字列を指定してください。',
    'array'                => ':attributeには配列を指定してください。',
    'before'               => ':attributeには:date以前の日付を指定してください。',
    'before_or_equal'      => ':attributeには:dateかそれ以前の日付を指定してください。',
    'between'              => [
        'numeric' => ':attributeには:min〜:maxまでの数値を指定してください。',
        'file'    => ':attributeには:min〜:max KBのファイルを指定してください。',
        'string'  => ':attributeには:min〜:max文字の文字列を指定してください。',
        'array'   => ':attributeには:min〜:max個の要素を持つ配列を指定してください。',
    ],
    'boolean'              => ':attributeには真偽値を指定してください。',
    'confirmed'            => ':attributeが確認用の値と一致しません。',

    'date_format'          => '":format"という形式の日付を指定してください。',
    'different'            => ':attributeには:otherとは異なる値を指定してください。',
    'digits'               => ':attributeには:digits桁の数値を指定してください。',
    'digits_between'       => ':attributeには:min〜:max桁の数値を指定してください。',
    'dimensions'           => ':attributeの画像サイズが不正です。',
    'distinct'             => '指定された:attributeは既に存在しています。',
    'email'                => ':attributeには正しい形式のメールアドレスを指定してください。',
    'exists'               => '指定された:attributeは存在しません。',
    'file'                 => ':attributeにはファイルを指定してください。',
    'filled'               => ':attributeには空でない値を指定してください。',
    'image'                => ':attributeには画像ファイルを指定してください。',
    'in'                   => ':attributeには:valuesのうちいずれかの値を指定してください。',
    'in_array'             => ':attributeが:otherに含まれていません。',
    'integer'              => ':attributeには整数を指定してください。',
    'ip'                   => ':attributeには正しい形式のIPアドレスを指定してください。',
    'ipv4'                 => ':attributeには正しい形式のIPv4アドレスを指定してください。',
    'ipv6'                 => ':attributeには正しい形式のIPv6アドレスを指定してください。',
    'json'                 => ':attributeには正しい形式のJSON文字列を指定してください。',
    'max'                  => [
        'numeric' => ':attributeには:max以下の数値を指定してください。',
        'file'    => ':attributeには:max KB以下のファイルを指定してください。',
        'string'  => ':attributeには:max文字以下の文字列を指定してください。',
        'array'   => ':attributeには:max個以下の要素を持つ配列を指定してください。',
    ],
    'mimes'                => ':attributeには:valuesのうちいずれかの形式のファイルを指定してください。',
    'mimetypes'            => ':attributeには:valuesのうちいずれかの形式のファイルを指定してください。',
    'min'                  => [
        'numeric' => ':attributeには:min以上の数値を指定してください。',
        'file'    => ':attributeには:min KB以上のファイルを指定してください。',
        'string'  => ':attributeには:min文字以上の文字列を指定してください。',
        'array'   => ':attributeには:min個以上の要素を持つ配列を指定してください。',
    ],
    'not_in'               => ':attributeには:valuesのうちいずれとも異なる値を指定してください。',

    'present'              => ':attributeには現在時刻を指定してください。',
    'regex'                => '正しい形式の:attributeを指定してください。',

    'required_if'          => ':otherが:valueの時:attributeは必須です。',
    'required_unless'      => ':otherが:values以外の時:attributeは必須です。',
    'required_with'        => ':valuesのうちいずれかが指定された時:attributeは必須です。',
    'required_with_all'    => ':valuesのうちすべてが指定された時:attributeは必須です。',
    'required_without'     => ':valuesのうちいずれかがが指定されなかった時:attributeは必須です。',
    'required_without_all' => ':valuesのうちすべてが指定されなかった時:attributeは必須です。',

    'size'                 => [
        'numeric' => ':attributeには:sizeを指定してください。',
        'file'    => ':attributeには:size KBのファイルを指定してください。',
        'string'  => ':attributeには:size文字の文字列を指定してください。',
        'array'   => ':attributeには:size個の要素を持つ配列を指定してください。',
    ],
    'string'               => ':attributeには文字列を指定してください。',
    'timezone'             => ':attributeには正しい形式のタイムゾーンを指定してください。',
    'unique'               => 'その:attributeはすでに使われています。',
    'uploaded'             => ':attributeのアップロードに失敗しました。',
    'url'                  => ':attributeには正しい形式のURLを指定してください。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'member_no' => '会員No',
        'password' => 'パスワード',
        'name' => '氏名',
        'password1' => 'パスワード',
        'password2' => 'パスワード（確認用）',
        'age' => '年齢',
        'zip' => '郵便番号',
        'address' => '住所',
        'tel' => '電話番号',
        'max_price' => '金額上限',
        'min_price' => '金額下限'
    ],

    //必須
    'required'             => ':attributeは必ず入力してください。',
    //半角数字_属性
    'numeric'              => ':attributeは半角数字で入力してください。',
    //半角数字_ハイフン
    'half_num_hyphen'      => ':attributeは半角数字とハイフンで入力してください。',
    //半角英数字
    'half_alpha_num'       => ':attributeは半角英数字で入力してください。',
    //日付
    'date'                 => ':attributeには存在する日付を入力してください。',
    //正数
    'positive_number'      => ':attributeには正の数で入力してください。',
    //桁数_一致_N
    'length_match'         => ':attributeは:n桁で入力してください。',
    //桁数_N以下
    'length_less'          => ':attributeは:n桁以下で入力してください。',
    //郵便番号
    'zip'                  => ':attributeはXXX-XXXXの形式で入力してください',
    //パスワード
    'same'                 => ':attributeと:otherは同じ値を入力してください。',
    //日付_前後「（項目名：終了日）は（項目名：開始日）より未来の日付を入力してください。

    //整合性_上限下限
    'greater_than_field'   => ':attributeは:fieldより大きい値を入力してください。',
    'less_than_field'      => ':fieldは:attributeより大きい値を入力してください。'
];
