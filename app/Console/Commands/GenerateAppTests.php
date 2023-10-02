<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateAppTests extends Command
{
    protected $signature = 'generate:app-tests';

    protected $description = 'Generate test files for app folder structure';

    public function handle()
    {

        $appDirectory = app_path();
        $keys = ['Service', 'Controller'];

        $this->generateTestFolders($appDirectory);
        $this->createTestFiles($appDirectory, $keys);
        $this->info('Test files generated successfully.');
    }

    public function generateTestFolders($sourceDirectory)
    {
        $directories = File::directories($sourceDirectory);

        foreach ($directories as $directory) {
            $newTestPath = str_replace('D:\lamviec\goldenowl\simple_laravel_project\school-verse\app', 'tests/Unit', $directory);

            File::makeDirectory($newTestPath, 0755, true, true);
            $this->info("Folder created: {$newTestPath} successfull");
            $this->generateTestFolders($directory);
        }
    }

    public function createTestFiles($sourceDirectory, $keys)
    {
        // Lấy danh sách tất cả các tệp
        $files = File::allFiles($sourceDirectory);

        foreach ($files as $file) {
            $filePath = $file->getRealPath();
            $fileNameSpace = str_replace('D:\lamviec\goldenowl\simple_laravel_project\school-verse\app\\', '', $file->getPath());
            if (! $this->contain($filePath, $keys)) {
                continue;
            }

            $newTestPath = str_replace('D:\lamviec\goldenowl\simple_laravel_project\school-verse\app\\', '', $filePath);
            $testFileName = substr($newTestPath, 0, -4).'Test.php';

            // Tạo đường dẫn đến tệp kiểm thử
            $testFilePath = base_path("tests/Unit/{$testFileName}");

            // Kiểm tra xem tệp kiểm thử đã tồn tại hay chưa
            if (! File::exists($testFilePath)) {
                $namespace = 'Tests\Unit\\'.$fileNameSpace;
                $className = pathinfo($filePath, PATHINFO_FILENAME);

                $testContent = "<?php\n\nnamespace {$namespace};\n\nuse Tests\TestCase;\n\n";
                $testContent .= "class {$className}Test extends TestCase\n{\n\n";

                $testContent .= "}\n";

                File::put($testFilePath, $testContent);
                echo "Test file created: {$testFilePath}\n";
            }
        }
    }

    public function contain($filePath, $keys)
    {
        foreach ($keys as $key) {
            if (strpos($filePath, $key) !== false) {
                return true;
            }
        }

        return false;
    }
}
