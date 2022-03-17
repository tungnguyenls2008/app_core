@extends('_backend.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Dashboard</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Dashboard Content</h3>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            This is backend dashboard
                        </div>
                    </div>
{{--                    <div class="card">--}}
{{--                        <div class="card-header">Experimental Parent-child radio</div>--}}
{{--                        <div class="card-body" >--}}
{{--                            <style>--}}
{{--                                .radio_item{--}}
{{--                                    display: none !important;--}}
{{--                                }--}}

{{--                                .label_item {--}}
{{--                                    opacity: 0.5;--}}
{{--                                }--}}

{{--                                .radio_item:checked + label {--}}
{{--                                    opacity: 1;--}}
{{--                                }--}}

{{--                                label {--}}
{{--                                    cursor: pointer;--}}
{{--                                }--}}
{{--                                .parent-ul > li,.child-ul > li{--}}
{{--                                    margin-left: 100px;--}}
{{--                                    position: relative;--}}
{{--                                    padding-left: 5px;--}}
{{--                                    display: block;--}}
{{--                                }--}}
{{--                                ul li::before {--}}
{{--                                    content: " ";--}}
{{--                                    position: absolute;--}}
{{--                                    width: 1px;--}}
{{--                                    background-color: #000;--}}
{{--                                    top: 5px;--}}
{{--                                    bottom: -50px;--}}
{{--                                    left: -100px;--}}
{{--                                }--}}
{{--                                body > ul > li:first-child::before {top: 12px;}--}}
{{--                                ul li:not(:first-child):last-child::before {display: none;}--}}
{{--                                ul li:only-child::before {--}}
{{--                                    display: list-item;--}}
{{--                                    content: " ";--}}
{{--                                    position: absolute;--}}
{{--                                    width: 1px;--}}
{{--                                    background-color: #000;--}}
{{--                                    top: 5px;--}}
{{--                                    bottom: 7px;--}}
{{--                                    height: 7px;--}}
{{--                                    left: -10px;--}}
{{--                                }--}}
{{--                                ul li::after {--}}
{{--                                    content: " ";--}}
{{--                                    position: absolute;--}}
{{--                                    left: -100px;--}}
{{--                                    width: 100px;--}}
{{--                                    height: 1px;--}}
{{--                                    background-color: #000;--}}
{{--                                    top: 50px;--}}
{{--                                }--}}
{{--                            </style>--}}
{{--                            <input type="radio" name="god-parent" class="god-parent radio_item" id="god-parent"/>--}}
{{--                            <label class="label_item" for="god-parent" ><img src="https://placeimg.com/100/100/any?{{rand(1, 100)}}" style="border-radius:25px"> </label>--}}
{{--                            <ul class="parent-ul" hidden >--}}
{{--                                <li>--}}
{{--                                    <!-- First parent -->--}}
{{--                                    <input type="radio" name="parent" class="parent radio_item" id="parent1"/>--}}
{{--                                    <label class="label_item" for="parent1" ><img src="https://placeimg.com/100/100/any?{{rand(1, 100)}}" style="border-radius:25px"> </label>--}}

{{--                                    <ul class="child-ul" hidden>--}}
{{--                                        <!-- Children of this one -->--}}
{{--                                        <li>--}}
{{--                                            <input type="radio" name="child1" class="child radio_item" id="child1-1"/>--}}
{{--                                            <label class="label_item" for="child1-1" ><img src="https://placeimg.com/100/100/any?{{rand(1, 100)}}" style="border-radius:25px"> </label>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <input type="radio" name="child1" class="child radio_item" id="child1-2"/>--}}
{{--                                            <label class="label_item" for="child1-2" ><img src="https://placeimg.com/100/100/any?{{rand(1, 100)}}" style="border-radius:25px"> </label>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <input type="radio" name="child1" class="child radio_item" id="child1-3"/>--}}
{{--                                            <label class="label_item" for="child1-3" ><img src="https://placeimg.com/100/100/any?{{rand(1, 100)}}" style="border-radius:25px"> </label>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                                <li>--}}
{{--                                    <!-- Second parent -->--}}
{{--                                    <input type="radio" name="parent" class="parent radio_item" id="parent2"/>--}}
{{--                                    <label class="label_item" for="parent2" ><img src="https://placeimg.com/100/100/any?{{rand(1, 100)}}" style="border-radius:25px"> </label>--}}

{{--                                    <ul class="child-ul" hidden>--}}
{{--                                        <!-- Children of this one -->--}}
{{--                                        <li>--}}
{{--                                            <input type="radio" name="child2" class="child radio_item" id="child2-1"/>--}}
{{--                                            <label class="label_item" for="child2-1" ><img src="https://placeimg.com/100/100/any?{{rand(1, 100)}}" style="border-radius:25px"> </label>--}}

{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <input type="radio" name="child2" class="child radio_item" id="child2-2"/>--}}
{{--                                            <label class="label_item" for="child2-2" ><img src="https://placeimg.com/100/100/any?{{rand(1, 100)}}" style="border-radius:25px"> </label>--}}

{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <input type="radio" name="child2" class="child radio_item" id="child2-3"/>--}}
{{--                                            <label class="label_item" for="child2-3" ><img src="https://placeimg.com/100/100/any?{{rand(1, 100)}}" style="border-radius:25px"> </label>--}}

{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                                <li>--}}
{{--                                    <!-- Third parent -->--}}
{{--                                    <input type="radio" name="parent" class="parent radio_item" id="parent3"/>--}}
{{--                                    <label class="label_item" for="parent3" ><img src="https://placeimg.com/100/100/any?{{rand(1, 100)}}" style="border-radius:25px"> </label>--}}

{{--                                    <ul class="child-ul" hidden>--}}
{{--                                        <!-- Children of this one -->--}}
{{--                                        <li>--}}
{{--                                            <input type="radio" name="child3" class="child radio_item" id="child3-1"/>--}}
{{--                                            <label class="label_item" for="child3-1" ><img src="https://placeimg.com/100/100/any?{{rand(1, 100)}}" style="border-radius:25px"> </label>--}}

{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <input type="radio" name="child3" class="child radio_item" id="child3-2"/>--}}
{{--                                            <label class="label_item" for="child3-2" ><img src="https://placeimg.com/100/100/any?{{rand(1, 100)}}" style="border-radius:25px"> </label>--}}

{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <input type="radio" name="child3" class="child radio_item" id="child3-3"/>--}}
{{--                                            <label class="label_item" for="child3-3" ><img src="https://placeimg.com/100/100/any?{{rand(1, 100)}}" style="border-radius:25px"> </label>--}}

{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                        <script>--}}
{{--                            $(function () {--}}
{{--                                $(".god-parent").on('change',function () {--}}
{{--                                    //$(".parent-ul").prop('hidden',false)--}}
{{--                                    $(".parent-ul").fadeIn().show();--}}
{{--                                })--}}
{{--                                $('input[type="radio"]').on('change', function() {--}}
{{--                                    $(this).next().next('ul').prop('hidden',false)--}}
{{--                                    $(this).next().next('ul').fadeIn().show();--}}
{{--                                    $('input[type="radio"]:not(:checked)').next().next('ul').prop('hidden',true)--}}
{{--                                    $('input[type="radio"]:not(:checked)').next().next('ul').fadeOut().hide();--}}
{{--                                    $('.child').prop("checked", false); // Reset all child checkbox--}}
{{--                                    // Check if it's a parent or child being checked--}}
{{--                                    if ($(this).hasClass('parent')) {--}}
{{--                                        $('.child').prop('required', false); // Set all children to not required--}}
{{--                                        $(this).next('ul').find('.child').prop('required', true);  // Set the children of the selected parent to required--}}
{{--                                    } else if ($(this).hasClass('child')) {--}}

{{--                                        $(this).prop("checked", true); // Check the selected child--}}
{{--                                        $(this).parent().parent().prev('.parent').prop('checked', true); // Check the selected parent--}}
{{--                                    }--}}
{{--                                });--}}
{{--                            })--}}
{{--                        </script>--}}
{{--                    </div>--}}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @include('flash::message')
                </div>

            </div>
        </div>
    </section>

@endsection

