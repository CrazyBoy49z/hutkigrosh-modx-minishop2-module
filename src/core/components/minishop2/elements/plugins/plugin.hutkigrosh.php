<?php
/** @var modX $modx */
switch ($modx->event->name) {
    // добавим автозагрузчик composer-а
    case 'OnMODXInit':
        $file = MODX_CORE_PATH . 'vendor/autoload.php';
        if (file_exists($file)) {
            require_once $file;
        }
        $file = MODX_CORE_PATH . 'components/minishop2/custom/payment/lib/SimpleAutoloader.php';
        if (file_exists($file)) {
            require_once $file;
        }
        // конфигурирование логгера через php, а не через xml, т.к необходимо задать путь к cache/logs/
        Logger::configure(array(
            'rootLogger' => array(
                'appenders' => array('fileAppender'),
                'level' => array('default'),
            ),
            'appenders' => array(
                'fileAppender' => array(
                    'class' => 'LoggerAppenderFile',
                    'layout' => array(
                        'class' => 'LoggerLayoutPattern',
                        'params' => array(
                            'conversionPattern' => '%date{Y-m-d H:i:s,u} | %logger{0} | %-5level | %msg %n%throwable',
                        )
                    ),
                    'params' => array(
                        'file' => MODX_CORE_PATH . 'cache/logs/hutkigrosh.log',
                        'append' => true
                    )
                )
            )
        ));
        break;
}
