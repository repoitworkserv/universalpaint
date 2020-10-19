@extends('layouts.user.app')

@section('content')

<div id="how-to-paint" class="container">
    <div class="row">
        <div class="title">HOW TO PAINT</div>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
        </p>
    </div>
    <div class="accordion" id="accordion-container">
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-container" href="#collapseOne">
                    PREPARING TO PAINT
                </a>
            </div>
            <div id="collapseOne" class="accordion-body collapse">
                <div class="accordion-inner">
                    <ul>
                        <li>Product selection - what am I going to paint?</li>
                        <li>How much paint is needed?</li>
                        <li>Preparing the room</li>
                        <li>Preparing the tools needed for painting</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-container" href="#collapseTwo">
                    PAINTING/APPLICATION
                </a>
            </div>
            <div id="collapseTwo" class="accordion-body collapse">
                <div class="accordion-inner">
                    <ul>
                        <li>Repairing damage walls
                            <ul class="sub-list">
                                <li>Fungi</li>
                                <li>Peeling paint</li>
                                <li>Rust</li>
                                <li>Holes and cracks</li>
                            </ul>
                        </li>

                        <li>Applying skimcoat / putty</li>
                        <li>Proper paint application
                            <ul class="sub-list">
                                <li>Wood</li>
                                <li>Metal and steel</li>
                                <li>Concrete</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-container" href="#collapseThree">
                    CLEAN-UP
                </a>
            </div>
            <div id="collapseThree" class="accordion-body collapse">
                <div class="accordion-inner">
                    <ul>
                        <li>Clean-up of room</li>
                        <li>Clean-up of tools</li>
                        <li>What to do with used paint / cans</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection