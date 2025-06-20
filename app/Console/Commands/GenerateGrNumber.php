<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GoodsReceipt;

class GenerateGrNumber extends Command
{
    protected $signature = 'gr:generate-number {id?}';
    protected $description = 'Generate unique GR number for Goods Receipt';

    public function handle()
    {
        $id = $this->argument('id');
        if ($id) {
            $gr = GoodsReceipt::find($id);
            if (!$gr) {
                $this->error('Goods Receipt not found.');
                return 1;
            }
            $gr_number = $this->generateGrNumber($gr->id);
            $gr->gr_number = $gr_number;
            $gr->save();
            $this->info('GR number generated: ' . $gr_number);
        } else {
            $nextId = (GoodsReceipt::max('id') ?? 0) + 1;
            $gr_number = $this->generateGrNumber($nextId);
            $this->info('Next GR number: ' . $gr_number);
        }
        return 0;
    }

    private function generateGrNumber($id)
    {
        return 'GR-' . date('Ymd') . str_pad($id, 3, '0', STR_PAD_LEFT);
    }
}
