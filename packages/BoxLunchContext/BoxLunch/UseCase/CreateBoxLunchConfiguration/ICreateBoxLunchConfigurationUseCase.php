<?php
namespace Packages\BoxLunchContext\BoxLunch\UseCase\CreateBoxLunchConfiguration;

interface ICreateBoxLunchConfigurationUseCase
{
    public function handle(CreateBoxLunchConfigurationInputData $input): CreateBoxLunchConfigurationOutputData;
}



