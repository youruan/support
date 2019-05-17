<?php
/**
 * Created by PhpStorm.
 * User: liuta
 * Date: 2018/11/15
 * Time: 10:20
 */

/**
 * @param $price
 * @param int $multiple
 * @param int $float
 * @return string
 * 格式化价格
 */
function format_price($price, $multiple = 100, $float = 2)
{
    return round($price / $multiple, $float);
}

/**
 * @param $amountYuan
 * @return int
 * 将元为单位的字符串转为以分记的整数
 */
function yuan_to_cent($amountYuan)
{
    return ceil($amountYuan * 100);
}

function hidden_part($string, $leftLength = 1, $rightLength = 2)
{
    return mb_substr($string, 0, $leftLength) . ' **** ' . $rightLength > 0 ? mb_substr($string, - $rightLength) : '';
}

function rand_number($id, $length = 12)
{
    return substr(rand(100000, 999999) . time() . $id . rand(1000, 9999), -$length);
}

/**
 * @param $path
 * @param string|null $disk
 * @return null|string
 */
function to_full_url($path, $disk = null)
{
    if(empty($path)) {
        return null;
    }

    // 如果字段本身就已经是完整的 url 就直接返回
    if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) {
        return $path;
    }

    return \Storage::disk($disk ?? config('filesystems.default'))->url($path);
}

function to_full_urls($paths)
{
    return collect($paths)->map(function ($one) {
        return to_full_url($one);
    })->values();
}

/**
 * @param $path
 * @param null $disk
 * @return array
 * 转化为路径和url的格式
 */
function to_full_url_and_path($path, $disk = null)
{
    return [
        'path' => $path,
        'url' => to_full_url($path, $disk),
    ];
}

function to_full_url_and_paths($paths, $disk = null)
{
    return collect($paths)->map(function ($path) use ($disk) {
        return to_full_url_and_path($path, $disk);
    });
}

/**
 * @param $duration
 * @return string
 * 时长转化为展示用的格式
 */
function format_duration($duration)
{
    $hours = floor($duration / 3600);
    $minutes = floor(($duration / 60) % 60);
    $seconds = floor($duration % 60);

    return str_pad($hours, 2, 0, STR_PAD_LEFT) . ':' . str_pad($minutes, 2, 0, STR_PAD_LEFT) . ':' . str_pad($seconds, 2, 0, STR_PAD_LEFT);
}

/**
 * @param $options
 * @param string $keyFieldName
 * @param string $valueFieldName
 * @return array
 * 包裹 key => value 类型的选项为二维数组
 */
function wrap_options($options, $keyFieldName = 'key', $valueFieldName = 'value')
{
    return collect($options)
        ->map(function ($label, $key) use ($keyFieldName, $valueFieldName) {

            return [
                $keyFieldName => $key,
                $valueFieldName => $label,
            ];
        })
        ->values()
        ->toArray();
}


/**
 * @param array $array
 * @param string $glue
 * @return string
 * 将数组的key转为用指定符号链接的字符串
 */
function keys_to_string(array $array, $glue = ',')
{
    return implode($glue, array_keys($array));
}
