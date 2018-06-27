<?php
/** @var modX $modx */
/** @var array $sources */
$snippets = array();
$tmp = array(
    'msHutkigroshSuccess' => 'ms_hutkigrosh_success',
);
foreach ($tmp as $k => $v) {
    /** @var modSnippet $snippet */
    $snippet = $modx->newObject('modSnippet');
    $snippet->fromArray(array(
        'id' => 0,
        'name' => $k,
        'description' => '',
        'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.' . $v . '.php'),
        'static' => BUILD_SNIPPET_STATIC,
        'source' => 1,
        'static_file' => 'core/components/' . PKG_NAME_LOWER . '/elements/snippets/snippet.' . $v . '.php',
    ), '', true, true);
    /** @noinspection PhpIncludeInspection */
    $propertiesFile = $sources['build'] . 'properties/properties.' . $v . '.php';
    if (file_exists($propertiesFile)) {
        $properties = include $propertiesFile;
        $snippet->setProperties($properties);
    }
    $snippets[] = $snippet;
}
unset($properties);
return $snippets;