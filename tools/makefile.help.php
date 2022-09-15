<?php

// v -> Displays the verbose documentation.
// f -> File to process.
// section -> Displays only the documentation sections matching.
$options = getopt('vf:', [
    'section:',
]);

$lines = file($options['f']);

$section = 0;
$command = '';
$inSection = false;
$help = [];

function displaySection(array $section, array $options): bool
{
    if (null === $sectionFilter = $options['section'] ?? null) {
        return true;
    }

    $headers = array_filter($section['headers'], function ($a) use ($sectionFilter) {
        return stripos($a, $sectionFilter);
    });

    return 1 === count($headers);
}

foreach ($lines as $line) {
    if (preg_match('/^####/', $line)) {
        $inSection = false;
        list(, $option, $comment) = preg_split('/(^####)|( -> )/', $line);
        $help[$section]['commands'][$command]['options'][] = sprintf("%-30s\t\033[36m%s\033[0m: %s", '', $option, $comment);
    } elseif (preg_match('/^##/', $line)) {
        if (!$inSection) {
            ++$section;
        }
        $inSection = true;
        $help[$section]['headers'][] = sprintf("\033[33m%s", str_replace('##', '', $line));
    } elseif (preg_match('/:.*?##/', $line)) {
        $inSection = false;
        list($command, $comment) = preg_split('/:.*?##/', $line);
        $help[$section]['commands'][$command]['name'] = sprintf("\033[32m%-30s\033[0m%s", $command, $comment);
    }
}

foreach ($help as $section) {
    if (!displaySection($section, $options)) {
        continue;
    }

    echo implode('', $section['headers']);
    usort($section['commands'], function ($a, $b) {
        return $a['name'] <=> $b['name'];
    });
    foreach ($section['commands'] as $command) {
        echo $command['name'];
        if (isset($command['options']) && isset($options['v'])) {
            sort($command['options']);
            echo implode('', $command['options']);
        }
    }
}
