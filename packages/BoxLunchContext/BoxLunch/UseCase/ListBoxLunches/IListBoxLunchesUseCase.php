<?php
namespace Packages\BoxLunchContext\BoxLunch\UseCase\ListBoxLunches;

interface IListBoxLunchesUseCase
{
    public function handle(ListBoxLunchesInputData $input): ListBoxLunchesOutputData;
}



