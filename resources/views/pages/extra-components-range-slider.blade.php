{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Range Slider')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/ionRangeSlider/css/ion.rangeSlider.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/ionRangeSlider/css/ion.rangeSlider.skinFlat.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div class="section">
  <div class="card">
    <div class="card-content">
      <p class="caption mb-0"><a href="http://ionden.com/a/plugins/ion.rangeSlider/en.html"
          target="_blank">ion.RangeSlider</a>
        is Easy, flexible and responsive range slider with skin support.</p>
    </div>
  </div>
  <!-- Basic Demo -->
  <div class="row">
    <div class="col s12">
      <div id="basic-demo" class="card card-tabs">
        <div class="card-content">
          <div class="card-title">
            <div class="row">
              <div class="col s12 m6 l10">
                <h4 class="card-title">Basic Demo</h4>
              </div>
              <div class="col s12 m6 l2">
                <ul class="tabs">
                  <li class="tab col s6 p-0"><a class="active p-0" href="#view-basic-demo">View</a></li>
                  <li class="tab col s6 p-0"><a class="p-0" href="#js-basic-demo">JS</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div id="view-basic-demo">
            <div class="row">
              <div class="col s12">
                <p>Simple start and customising basic params</p>
              </div>
              <div class="col s12">
                <p>Start without params</p>
              </div>
              <div class="col s12">
                <input type="range" id="range_01">
              </div>
            </div>
          </div>
          <div id="js-basic-demo">
            <pre class="language-javascript"><code class="language-javascript" data-language="javascript">
    $("#range_01").ionRangeSlider();
  </code> </pre>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Set Value -->
  <div class="row">
    <div class="col s12">
      <div id="set-value" class="card card-tabs">
        <div class="card-content">
          <div class="card-title">
            <div class="row">
              <div class="col s12 m6 l10">
                Set Value
              </div>
              <div class="col s12 m6 l2">
                <ul class="tabs">
                  <li class="tab col s6 p-0"><a class="active p-0" href="#view-set-value">View</a></li>
                  <li class="tab col s6 p-0"><a class="p-0" href="#html-set-value">JS</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div id="view-set-value">
            <div class="row">
              <div class="col s12">
                <p>Set min value, max value and start point</p>
              </div>
              <div class="col s12">
                <input type="range" id="range_02">
              </div>
            </div>
          </div>
          <div id="html-set-value">
            <pre class="language-javascript"><code class="language-javascript" data-language="javascript">
  $("#range_02").ionRangeSlider({
    min: 100,
    max: 1000,
    from: 550
  });
 </code> </pre>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Specify Range -->
  <div class="row">
    <div class="col s12">
      <div id="specify-range" class="card card-tabs">
        <div class="card-content">
          <div class="card-title">
            <div class="row">
              <div class="col s12 m6 l10">
                Specify Range
              </div>
              <div class="col s12 m6 l2">
                <ul class="tabs">
                  <li class="tab col s6 p-0"><a class="active p-0" href="#view-specify-range">View</a></li>
                  <li class="tab col s6 p-0"><a class="p-0" href="#html-specify-range">JS</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div id="view-specify-range">
            <div class="row">
              <div class="col s12">
                <p>Set type to double and specify range, also showing grid and adding prefix "$"</p>
              </div>
              <div class="col s12">
                <input type="range" id="range_03">
              </div>
            </div>
          </div>
          <div id="html-specify-range">
            <pre class="language-javascript"><code class="language-javascript" data-language="javascript">
  $("#range_03").ionRangeSlider({
    type: "double",
    grid: true,
    min: 0,
    max: 1000,
    from: 200,
    to: 800,
    prefix: "$"
  });
</code></pre>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--Set up range and step-->
  <div class="row">
    <div class="col s12">
      <div id="setup-range" class="card card-tabs">
        <div class="card-content">
          <div class="card-title">
            <div class="row">
              <div class="col s12 m6 l10">
                Set up range and step
              </div>
              <div class="col s12 m6 l2">
                <ul class="tabs">
                  <li class="tab col s6 p-0"><a class="active p-0" href="#view-setup-range">View</a></li>
                  <li class="tab col s6 p-0"><a class="p-0" href="#html-setup-range">JS</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div id="view-setup-range">
            <div class="row">
              <div class="col s12">
                <p>Set up range with negative values</p>
              </div>
              <div class="col s12">
                <input type="range" id="range_04">
              </div>
            </div>
          </div>
          <div id="html-setup-range">
            <pre class="language-javascript"><code class="language-javascript" data-language="javascript">
  $("#range_04").ionRangeSlider({
    type: "double",
    grid: true,
    min: -1000,
    max: 1000,
    from: -500,
    to: 500
  });
</code></pre>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Fractional Values -->
  <div class="row">
    <div class="col s12">
      <div id="fractional-values" class="card card-tabs">
        <div class="card-content">
          <div class="card-title">
            <div class="row">
              <div class="col s12 m6 l10">
                Fractional Values
              </div>
              <div class="col s12 m6 l2">
                <ul class="tabs">
                  <li class="tab col s6 p-0"><a class="active p-0" href="#view-fractional-values">View</a></li>
                  <li class="tab col s6 p-0"><a class="p-0" href="#html-fractional-values">JS</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div id="view-fractional-values">
            <div class="row">
              <div class="col s12">
                <p>Set up range with fractional values, using fractional step</p>
              </div>
              <div class="col s12">
                <input type="range" id="range_05">
              </div>
            </div>
          </div>
          <div id="html-fractional-values">
            <pre class="language-javascript"><code class="language-javascript" data-language="javascript">
  $("#range_04").ionRangeSlider({
    type: "double",
    grid: true,
    min: -1000,
    max: 1000,
    from: -500,
    to: 500
  });
</code></pre>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col s12">
      <div id="with-strings" class="card card-tabs">
        <div class="card-content">
          <div class="card-title">
            <div class="row">
              <div class="col s12 m6 l10">
                With Strings
              </div>
              <div class="col s12 m6 l2">
                <ul class="tabs">
                  <li class="tab col s6 p-0"><a class="active p-0" href="#view-with-strings">View</a></li>
                  <li class="tab col s6 p-0"><a class="p-0" href="#html-with-strings">JS</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div id="view-with-strings">
            <div class="row">
              <div class="col s12">
                <p>One more example with strings</p>
              </div>
              <div class="col s12">
                <input type="range" id="range_09">
              </div>
            </div>
          </div>
          <div id="html-with-strings">
            <pre class="language-javascript"><code class="language-javascript" data-language="javascript">
  $("#range_09").ionRangeSlider({
    grid: true,
    from: 3,
    values: [
      "January", "February", "March",
      "April", "May", "June",
      "July", "August", "September",
      "October", "November", "December"
    ]
  });
</code></pre>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

{{-- vendor script --}}
@section('vendor-script')
<script src="{{asset('vendors/ionRangeSlider/js/ion.rangeSlider.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
<script src="{{asset('js/scripts/extra-components-range-slider.js')}}"></script>
@endsection