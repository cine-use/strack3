<?php

define('VENDOR_PATH', __DIR__ . '/../../vendor/');

require VENDOR_PATH . '/autoload.php';

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

$language = new ExpressionLanguage();

class testClass
{
}

$testClass = new testClass();
$testClass->num_a = 10;
$testClass->num_b = 20;
$testClass->num_c = 30;
$testClass->check1 = false;
$testClass->check2 = true;

print_r($testClass);


echo '----------加法----------';
echo PHP_EOL;

echo '表达式：test1.num_a + test1.num_b';
echo PHP_EOL;

echo '结果：' . $language->evaluate(
        'test1.num_a + test1.num_b',
        array(
            'test1' => $testClass,
        )
    );

echo PHP_EOL;

echo '----------减法----------';
echo PHP_EOL;

echo '表达式：test1.num_a - test1.num_b';
echo PHP_EOL;

echo '结果：' . $language->evaluate(
        'test1.num_a - test1.num_b',
        array(
            'test1' => $testClass,
        )
    );

echo PHP_EOL;

echo '----------乘法----------';
echo PHP_EOL;

echo '表达式：test1.num_a * test1.num_b';
echo PHP_EOL;

echo '结果：' . $language->evaluate(
        'test1.num_a * test1.num_b',
        array(
            'test1' => $testClass,
        )
    );

echo PHP_EOL;

echo '----------除法----------';
echo PHP_EOL;

echo '表达式：test1.num_a / test1.num_b';
echo PHP_EOL;

echo '结果：' . $language->evaluate(
        'test1.num_a / test1.num_b',
        array(
            'test1' => $testClass,
        )
    );

echo PHP_EOL;

echo '----------取余----------';
echo PHP_EOL;

echo '表达式：test1.num_a % test1.num_b';
echo PHP_EOL;

echo '结果：' . $language->evaluate(
        'test1.num_a % test1.num_b',
        array(
            'test1' => $testClass,
        )
    );

echo PHP_EOL;

echo '----------指数----------';
echo PHP_EOL;

echo '表达式：test1.num_a ** test1.num_b';
echo PHP_EOL;

echo '结果：' . $language->evaluate(
        'test1.num_a ** test1.num_b',
        array(
            'test1' => $testClass,
        )
    );


echo PHP_EOL;

echo '----------in 和 not in----------';
echo PHP_EOL;

echo '表达式：test1.num_a in [12, 20]';
echo PHP_EOL;

echo $language->evaluate(
    'test1.num_a in [12, 20]',
    array(
        'test1' => $testClass,
    )
) == 1 ? '结果：在里面' : '结果：不在里面';

echo PHP_EOL;

echo '----------range区间----------';
echo PHP_EOL;

echo '表达式：test1.num_a in 8..45';
echo PHP_EOL;

echo $language->evaluate(
    'test1.num_a in 8..45',
    array(
        'test1' => $testClass,
    )
) == 1 ? '结果：在里面' : '结果：不在里面';


echo PHP_EOL;

echo '----------三元运算----------';
echo PHP_EOL;

echo '表达式：test1.num_a == 10 ? test1.check2 ? test1.num_c : test1.num_b : test1.num_a';
echo PHP_EOL;

echo '结果：' . $language->evaluate(
        'test1.num_a == 10 ? test1.check2 ? test1.num_c : test1.num_b : test1.num_a',
        array(
            'test1' => $testClass,
        )
    );


echo PHP_EOL;

echo '----------级联----------';
echo PHP_EOL;

echo '表达式：test1.num_c~" "~test1.num_a';
echo PHP_EOL;

echo '结果：' . $language->evaluate(
        'test1.num_c~" "~test1.num_a',
        array(
            'test1' => $testClass,
        )
    );

echo PHP_EOL;

echo '----------逻辑运算 not or ! ----------';
echo PHP_EOL;

echo '表达式：!test1.check1';
echo PHP_EOL;

echo $language->evaluate(
    '!test1.check1',
    array(
        'test1' => $testClass,
    )
) == 1 ? '结果：yes' : '结果：no';


echo PHP_EOL;

echo '----------逻辑运算 and or && ----------';
echo PHP_EOL;

echo '表达式：test1.num_c > 0 && test1.num_a > 0';
echo PHP_EOL;

echo $language->evaluate(
    'test1.num_c > 0 && test1.num_a > 0',
    array(
        'test1' => $testClass,
    )
) == 1 ? '结果：yes' : '结果：no';


echo PHP_EOL;

echo '----------逻辑运算 or or || ----------';
echo PHP_EOL;

echo '表达式：test1.num_c > 0 || test1.num_a < 0';
echo PHP_EOL;

echo $language->evaluate(
    'test1.num_c > 0 || test1.num_a < 0',
    array(
        'test1' => $testClass,
    )
) == 1 ? '结果：yes' : '结果：no';

echo PHP_EOL;
echo '----------比较运算 支持以下方法----------';
echo PHP_EOL;
echo '== (equal)';
echo PHP_EOL;
echo '=== (identical)';
echo PHP_EOL;
echo '!= (not equal)';
echo PHP_EOL;
echo '!== (not identical)';
echo PHP_EOL;
echo '< (less than)';
echo PHP_EOL;
echo '> (greater than)';
echo PHP_EOL;
echo '<= (less than or equal to)';
echo PHP_EOL;
echo '>= (greater than or equal to)';
echo PHP_EOL;
echo 'matches (regex match)';

echo PHP_EOL;

echo '----------案例 ----------';
echo PHP_EOL;

echo '表达式：test1.num_c matches "/bar/"';
echo PHP_EOL;

echo $language->evaluate(
    'test1.num_c matches "/bar/"',
    array(
        'test1' => $testClass,
    )
) == 1 ? '结果：yes' : '结果：no';
