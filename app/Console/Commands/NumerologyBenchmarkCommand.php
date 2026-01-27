<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\NumerologyCalculator;
use App\Services\PersonalCyclesCalculator;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Stopwatch\Stopwatch;

final class NumerologyBenchmarkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'benchmark:numerology-calculations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Benchmark numerology calculation performance';

    private const BENCHMARK_ITERATIONS = 10000;

    public function handle(
        NumerologyCalculator $numerologyCalculator,
        PersonalCyclesCalculator $cyclesCalculator
    ): int {
        $this->info('Starting Numerology Calculations Benchmark');
        $stopwatch = new Stopwatch();

        $benchmarks = [
            'Life Path Calculation' => fn() => $this->benchmarkLifePathCalculation($numerologyCalculator),
            'Expression Number' => fn() => $this->benchmarkExpressionNumber($numerologyCalculator),
            'Personal Cycles' => fn() => $this->benchmarkPersonalCycles($cyclesCalculator),
        ];

        $progressBar = $this->output->createProgressBar(count($benchmarks));
        $progressBar->start();

        $results = [];
        foreach ($benchmarks as $name => $benchmark) {
            $stopwatch->start($name);
            $result = $benchmark();
            $event = $stopwatch->stop($name);

            $results[$name] = [
                'duration' => $event->getDuration(),
                'memory' => $event->getMemory(),
                'average_time_per_iteration' => $event->getDuration() / self::BENCHMARK_ITERATIONS,
            ];

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->table(
            ['Benchmark', 'Total Duration (ms)', 'Memory Used (bytes)', 'Avg. Time/Iteration (ms)'],
            collect($results)->map(fn($result, $name) => [
                $name,
                $result['duration'],
                $result['memory'],
                round($result['average_time_per_iteration'], 4)
            ])->toArray()
        );

        $this->warn('Benchmark completed. Results above.');
        return self::SUCCESS;
    }

    private function benchmarkLifePathCalculation(NumerologyCalculator $calculator): void
    {
        for ($i = 0; $i < self::BENCHMARK_ITERATIONS; $i++) {
            $birthDate = CarbonImmutable::create(
                rand(1950, 2000), 
                rand(1, 12), 
                rand(1, 28)
            );
            $calculator->calculateLifePath($birthDate);
        }
    }

    private function benchmarkExpressionNumber(NumerologyCalculator $calculator): void
    {
        $names = [
            'John Albert Doe',
            'Emma Rose Johnson',
            'Michael Christopher Smith',
            'Sophia Elizabeth Brown'
        ];

        for ($i = 0; $i < self::BENCHMARK_ITERATIONS; $i++) {
            $name = $names[array_rand($names)];
            $calculator->calculateExpression($name);
        }
    }

    private function benchmarkPersonalCycles(PersonalCyclesCalculator $calculator): void
    {
        $birthDate = CarbonImmutable::create(1990, 6, 15);

        for ($i = 0; $i < self::BENCHMARK_ITERATIONS; $i++) {
            $targetDate = $birthDate->addYears(rand(1, 30));
            $calculator->calculatePersonalYear($birthDate, $targetDate);
            $calculator->calculatePersonalMonth($birthDate, $targetDate);
            $calculator->calculatePersonalDay($birthDate, $targetDate);
        }
    }
}