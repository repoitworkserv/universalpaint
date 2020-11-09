@extends('layouts.user.app')

@section('content')
<div id="paint-calculator">
    <div class="container">
        <div class="heading">PAINT CALCULATOR</div>
        <div class="sub-heading">lorem ipsum</div>
        <div class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</div>

        <div class="row">
            <div class="col-lg-4">
                <div id="criteria-container">
                    <input type="hidden" id="query-string-value" value="<?php echo isset($_GET['paint']) ? $_GET['paint'] : "" ?>">
                    <div>
                        <label class="label">SURFACE TYPE</label> <span class="required">*</span>
                        <ul class="customComboBox">
                            <label id="surface-type" class="default value">- Surface type -</label> <span class="fa fa-chevron-down"></span>
                            <li>WOOD</li>
                            <li>METAL AND STEEL</li>
                            <li>CONCRETE</li>
                        </ul>
                    </div>
                    <div>
                        <label class="label">SURFACE LOCATION</label> <span class="required">*</span>
                        <ul class="customComboBox">
                            <label id="surface-location" class="default value">- Surface location -</label> <span class="fa fa-chevron-down"></span>
                            <li>INTERIOR</li>
                            <li>EXTERIOR</li>
                        </ul>
                    </div>
                    <div>
                        <label class="label">SURFACE CONDITION</label> <span class="required">*</span>
                        <ul class="customComboBox">
                            <label id="surface-condition" class="default value">- Surface condition -</label> <span class="fa fa-chevron-down"></span>
                            <li>NEW PAINT</li>
                            <li>RE-PAINT</li>
                        </ul>
                    </div>
                    <div>
                        <label class="label">AREA IN SQM</label> <span class="required">*</span>
                        <input disabled id="area-in-sqm" type="text" placeholder="Area in sqm">
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div id="result-container" style="display: none;">
                    <span class="result">RESULT</span>
                    <br><br>
                    <div class="row" id="paint-liter">
                        <div id="paint" class="col-lg-10">
                            {{-- <p>USE</p> --}}
                            {{-- <div class="paint">Universal Aquaguard (Elastomeric Paint)</div>
                            <div class="paint">sample product name (Sample description)</div>
                            <div class="paint">sample product name (Sample description)</div> --}}
                        </div>
                        <div id="liter" class="col-lg-2">
                            {{-- <p>LITERS</p> --}}
                            {{-- <div class="liter">1</div>
                            <div class="liter">2</div>
                            <div class="liter">3</div> --}}
                        </div>
                    </div>
                    <div class="note"><label style="font-weight: bold; margin-bottom: 0;">Note:</label> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection