<?php

namespace app\commands;

use yii\console\Controller;
use yii\helpers\Console;
use app\models\Issue;


class ImportIssuesController extends Controller
{
    /**
     * Імпортує логи у вигляді проблем до задачі.
     *
     * @param string $path шлях до лог-файлу
     * @return int
     */
    public function actionIndex($path)
    {
        if (!file_exists($path)) {
            $this->stderr("Файл не знайдено: $path\n", Console::FG_RED);
            return 1;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $imported = 0;

        foreach ($lines as $line) {
            if (preg_match('/^\[(?<datetime>[\d\-:\s]+)\] - (?<type>[^-]+) - (?<code>[^-]+) - (?<message>.+)$/', $line, $matches)) {
                $name = trim($matches['code'] . ' - ' . $matches['type']);
                $description = trim($matches['message']);

                $exists = Issue::find()
                    ->where(['name' => $name, 'enable' => 1])
                    ->exists();

                if ($exists) {
                    continue;
                }

                $issue = new Issue();
                $issue->task_id = null;
                $issue->name = $name;
                $issue->description = $description;
                $issue->enable = 1;
                $issue->save(true);

                $imported++;
            }
        }



        $this->stdout("Готово. Імпортовано $imported проблем.\n", Console::FG_BLUE);
        return 0;
    }
}
