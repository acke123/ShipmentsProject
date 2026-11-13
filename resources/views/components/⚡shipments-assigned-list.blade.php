<?php

use Livewire\Component;

new class extends Component {
    public int $count = 0;
    public int|string|null $amount = 1;
    public string $errorMsg ='';

    public function increment()
    {
        $this->errorMsg = '';
        if (is_null($this->amount)) {
            $this->amount = 1;
        }
        $this->count += $this->amount;
    }

    public function decrease()
    {
        $this->errorMsg = '';
        if ($this->count > 0) {
            if (is_null($this->amount)) {
                $this->amount = 1;
            }

            if ($this->count - $this->amount >= 0) {
                $this->count -= $this->amount;
            } else {
                $this->errorMsg = 'Error lower than 0';
            }
        }
    }
};
?>

<div>
    <p>Clicked Times: {{$count}}</p>
    <button wire:click="increment()">Click +</button>
    <button wire:click="decrease()">Click -</button>

    <input type="number" min="1" wire:model.debounce="amount">
    <p>{{$amount}}</p>
    <p>{{$errorMsg}}</p>
</div>
