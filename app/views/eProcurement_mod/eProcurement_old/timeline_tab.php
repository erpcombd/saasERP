
<style>
:root, [data-bs-theme=light] {
    --bs-blue: #0d6efd;
    --bs-indigo: #6610f2;
    --bs-purple: #6f42c1;
    --bs-pink: #d63384;
    --bs-red: #dc3545;
    --bs-orange: #fd7e14;
    --bs-yellow: #ffc107;
    --bs-green: #198754;
    --bs-teal: #20c997;
    --bs-cyan: #0dcaf0;
    --bs-black: #000;
    --bs-white: #fff;
    --bs-gray: #6c757d;
    --bs-gray-dark: #343a40;
    --bs-gray-100: #f8f9fa;
    --bs-gray-200: #e9ecef;
    --bs-gray-300: #dee2e6;
    --bs-gray-400: #ced4da;
    --bs-gray-500: #adb5bd;
    --bs-gray-600: #6c757d;
    --bs-gray-700: #495057;
    --bs-gray-800: #343a40;
    --bs-gray-900: #212529;
    --bs-primary: #0d6efd;
    --bs-secondary: #6c757d;
    --bs-success: #198754;
    --bs-info: #0dcaf0;
    --bs-warning: #ffc107;
    --bs-danger: #dc3545;
    --bs-light: #f8f9fa;
    --bs-dark: #212529;
    --bs-primary-rgb: 13, 110, 253;
    --bs-secondary-rgb: 108, 117, 125;
    --bs-success-rgb: 25, 135, 84;
    --bs-info-rgb: 13, 202, 240;
    --bs-warning-rgb: 255, 193, 7;
    --bs-danger-rgb: 220, 53, 69;
    --bs-light-rgb: 248, 249, 250;
    --bs-dark-rgb: 33, 37, 41;
    --bs-primary-text-emphasis: #052c65;
    --bs-secondary-text-emphasis: #2b2f32;
    --bs-success-text-emphasis: #0a3622;
    --bs-info-text-emphasis: #055160;
    --bs-warning-text-emphasis: #664d03;
    --bs-danger-text-emphasis: #58151c;
    --bs-light-text-emphasis: #495057;
    --bs-dark-text-emphasis: #495057;
    --bs-primary-bg-subtle: #cfe2ff;
    --bs-secondary-bg-subtle: #e2e3e5;
    --bs-success-bg-subtle: #d1e7dd;
    --bs-info-bg-subtle: #cff4fc;
    --bs-warning-bg-subtle: #fff3cd;
    --bs-danger-bg-subtle: #f8d7da;
    --bs-light-bg-subtle: #fcfcfd;
    --bs-dark-bg-subtle: #ced4da;
    --bs-primary-border-subtle: #9ec5fe;
    --bs-secondary-border-subtle: #c4c8cb;
    --bs-success-border-subtle: #a3cfbb;
    --bs-info-border-subtle: #9eeaf9;
    --bs-warning-border-subtle: #ffe69c;
    --bs-danger-border-subtle: #f1aeb5;
    --bs-light-border-subtle: #e9ecef;
    --bs-dark-border-subtle: #adb5bd;
    --bs-white-rgb: 255, 255, 255;
    --bs-black-rgb: 0, 0, 0;
    --bs-font-sans-serif: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    --bs-font-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    --bs-gradient: linear-gradient(180deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
    --bs-body-font-family: var(--bs-font-sans-serif);
    --bs-body-font-size: 1rem;
    --bs-body-font-weight: 400;
    --bs-body-line-height: 1.5;
    --bs-body-color: #212529;
    --bs-body-color-rgb: 33, 37, 41;
    --bs-body-bg: #fff;
    --bs-body-bg-rgb: 255, 255, 255;
    --bs-emphasis-color: #000;
    --bs-emphasis-color-rgb: 0, 0, 0;
    --bs-secondary-color: rgba(33, 37, 41, 0.75);
    --bs-secondary-color-rgb: 33, 37, 41;
    --bs-secondary-bg: #e9ecef;
    --bs-secondary-bg-rgb: 233, 236, 239;
    --bs-tertiary-color: rgba(33, 37, 41, 0.5);
    --bs-tertiary-color-rgb: 33, 37, 41;
    --bs-tertiary-bg: #f8f9fa;
    --bs-tertiary-bg-rgb: 248, 249, 250;
    --bs-heading-color: inherit;
    --bs-link-color: #0d6efd;
    --bs-link-color-rgb: 13, 110, 253;
    --bs-link-decoration: underline;
    --bs-link-hover-color: #0a58ca;
    --bs-link-hover-color-rgb: 10, 88, 202;
    --bs-code-color: #d63384;
    --bs-highlight-color: #212529;
    --bs-highlight-bg: #fff3cd;
    --bs-border-width: 1px;
    --bs-border-style: solid;
    --bs-border-color: #dee2e6;
    --bs-border-color-translucent: rgba(0, 0, 0, 0.175);
    --bs-border-radius: 0.375rem;
    --bs-border-radius-sm: 0.25rem;
    --bs-border-radius-lg: 0.5rem;
    --bs-border-radius-xl: 1rem;
    --bs-border-radius-xxl: 2rem;
    --bs-border-radius-2xl: var(--bs-border-radius-xxl);
    --bs-border-radius-pill: 50rem;
    --bs-box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    --bs-box-shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    --bs-box-shadow-lg: 0 1rem 3rem rgba(0, 0, 0, 0.175);
    --bs-box-shadow-inset: inset 0 1px 2px rgba(0, 0, 0, 0.075);
    --bs-focus-ring-width: 0.25rem;
    --bs-focus-ring-opacity: 0.25;
    --bs-focus-ring-color: rgba(13, 110, 253, 0.25);
    --bs-form-valid-color: #198754;
    --bs-form-valid-border-color: #198754;
    --bs-form-invalid-color: #dc3545;
    --bs-form-invalid-border-color: #dc3545;
}
.py-8 {
    padding-bottom: 4.5rem!important;
    padding-top: 4.5rem!important;
}

@media(min-width:576px) {
    .py-sm-8 {
        padding-bottom: 4.5rem!important;
        padding-top: 4.5rem!important;
    }
}

@media(min-width:768px) {
    .py-md-8 {
        padding-bottom: 4.5rem!important;
        padding-top: 4.5rem!important;
    }
}

@media(min-width:992px) {
    .py-lg-8 {
        padding-bottom: 4.5rem!important;
        padding-top: 4.5rem!important;
    }
}

@media(min-width:1200px) {
    .py-xl-8 {
        padding-bottom: 4.5rem!important;
        padding-top: 4.5rem!important;
    }
}

@media(min-width:1400px) {
    .py-xxl-8 {
        padding-bottom: 4.5rem!important;
        padding-top: 4.5rem!important;
    }
}

.bsb-timeline-7 {
    --bsb-tl-color: var(--bs-primary-bg-subtle);
    --bsb-tl-circle-color: var(--bs-light);
    --bsb-tl-circle-border-color: var(--bs-primary);
    --bsb-tl-indicator-color: var(--bs-white);
    --bsb-tl-circle-size: 16px;
    --bsb-tl-circle-offset: 8px;
    --bsb-tl-circle-border-size: 2px;
}

.bsb-timeline-7 .timeline {
    list-style: none;
    margin: 0;
    padding: 0;
    position: relative;
}

.bsb-timeline-7 .timeline:after {
    background-color: var(--bsb-tl-color);
    bottom: 0;
    content: "";
    left: 0;
    margin-left: -1px;
    position: absolute;
    top: 0;
    width: 2px;
}

@media(min-width:768px) {
    .bsb-timeline-7 .timeline:after {
        left: 33%;
    }
}

.bsb-timeline-7 .timeline>.timeline-item {
    margin: 0;
    padding: 0;
    position: relative;
}

.bsb-timeline-7 .timeline>.timeline-item:after {
    background: var(--bsb-tl-circle-color);
    border: var(--bsb-tl-circle-border-size) solid var(--bsb-tl-circle-border-color);
    border-radius: 50%;
    content: "";
    height: var(--bsb-tl-circle-size);
    left: calc(var(--bsb-tl-circle-offset)*-1);
    position: absolute;
    top: calc(50% - var(--bsb-tl-circle-offset));
    width: var(--bsb-tl-circle-size);
    z-index: 1;
}

.bsb-timeline-7 .timeline>.timeline-item .timeline-body {
    margin: 0;
    padding: 0;
    position: relative;
}

.bsb-timeline-7 .timeline>.timeline-item .timeline-meta {
    padding: 0 0 1rem 2.5rem;
}

.bsb-timeline-7 .timeline>.timeline-item:first-child .timeline-meta {
    padding: 2.5rem 0 1rem 2.5rem;
}

.bsb-timeline-7 .timeline>.timeline-item .timeline-content {
    padding: 0 0 2.5rem 0;
}

@media(min-width:768px) {
    .bsb-timeline-7 .timeline>.timeline-item {
        left: 33%;
        width: 67%;
    }
    .bsb-timeline-7 .timeline>.timeline-item .timeline-meta {
        display: flex;
        justify-content: flex-end;
        left: -100%;
        margin: 0;
        padding: 0 2.5rem 0 0;
        position: absolute;
        top: calc(50% - 29px);
        width: 100%;
        z-index: 1;
    }
    .bsb-timeline-7 .timeline>.timeline-item:first-child .timeline-meta {
        padding: 0 2.5rem 0 0;
    }
    .bsb-timeline-7 .timeline>.timeline-item .timeline-content {
        padding: 2.5rem;
    }
    .bsb-timeline-7 .timeline>.timeline-item .timeline-indicator {
        position: relative;
    }
    .bsb-timeline-7 .timeline>.timeline-item .timeline-indicator:after {
        border-width: 1px;
        border: 10px solid var(--bsb-tl-indicator-color);
        border-color: transparent var(--bsb-tl-indicator-color) transparent transparent;
        border-left-width: 0;
        content: "";
        left: calc(2.5rem - 10px);
        position: absolute;
        top: calc(50% - var(--bsb-tl-circle-offset));
        z-index: 1;
    }
}
.bg-success-subtle {
    background-color: var(--bs-success-bg-subtle) !important;
}


@media (min-width: 768px){}
.bsb-timeline-7 .timeline>.timeline-item .timeline-indicator:after {
    border-width: 1px;
    border: 10px solid var(--bsb-tl-indicator-color);
    border-color: transparent var(--bsb-tl-indicator-color) transparent transparent;
    border-left-width: 0;
    content: "";
    left: calc(2.5rem - 10px);
    position: absolute;
    top: calc(50% - var(--bsb-tl-circle-offset));
    z-index: 1;
}

*, ::after, ::before {
    box-sizing: border-box;
}
.btn-task-add {
    background-color: #cfe2ff;
    border: none;
    border-radius: 4px;
    box-shadow: 0 4px 10px 0 rgba(0,0,0,0.2), 0 3px 3px 0 rgba(0,0,0,0.19);
}
.timeline-body .timeline-content{
	padding-top: 5px !important;
	padding-bottom: 5px !important;
}
</style>
<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="timeline-tab">


	
	
<div class="pt-5 pl-3">
		
		<div   class="row align-items-center">
		
		  <label class="col-3 fs-18 bold" for=" eventtimezone" style="font-size: 14px !important;color: #60768a; !important">Event Time Zone :</label>
		  
			<input class="col-3" type="text" id="eventtimezone" name="eventtimezone" style="width: 40% !important;" list="timezoneList" value="<?=$eventtimezone?>" onchange="master_data(this.name,this.value)">
			
		</div>
	
		
	   
		<div   class="mt-2 row align-items-center">
		
		  <label class="col-3 fs-18 bold" style="font-size: 14px !important;color: #60768a; !important" for="eventend">Event Start Date :</label>
		 
		  <input type="date" style="border: 1px solid #ced4da; border-radius: 0.25rem;" class="form-control pt-1 col-3" id="eventStartDate" name="eventStartDate" value="<?=$eventStartDate?>" style="width: 12% !important;" onchange="master_data(this.name,this.value)" />
		  <input type="Time" style="border: 1px solid #ced4da; border-radius: 0.25rem;" class="form-control  pt-1 col-3 ml-2" id="eventStartTime" name="eventStartTime" value="<?=$eventStartTime?>"  style="width: 12% !important;" onchange="master_data(this.name,this.value)" />
		</div>
		
		<div   class="mt-2 row align-items-center">
		  <label class="col-3 fs-18 bold" style="font-size: 14px !important;color: #60768a; !important" for="eventend" style="font-size: 14px !important;color: #60768a; !important">Event End At</label>
		  
		  <input type="Date" style="border: 1px solid #ced4da; border-radius: 0.25rem;" class="form-control pt-1 col-3" id="eventEndDate" name="eventEndDate" value="<?=$eventEndDate?>" style="width: 12% !important;" onchange="master_data(this.name,this.value)" />
		  <input type="Time" style="border: 1px solid #ced4da; border-radius: 0.25rem;" class="form-control pt-1 col-3 ml-2" id="eventEndTime" name="eventEndTime" value="<?=$eventEndTime?>"  style="width: 12% !important;" onchange="master_data(this.name,this.value)" />
		</div>
		
	
		
	  </div>

	  <h1 class="h1 m-0 p-0 pt-4 pl-3" style="font-size: 30px !important;"><em class="fa-light fa-timeline"></em> Timeline </h1>
		<hr style="height:1px;border:none;color:#333;background-color:#333;">

	
<section class="bsb-timeline-7 ">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-10 col-md-12 col-xl-10 col-xxl-9">

        <ul class="timeline">
          <li class="timeline-item">
            <div class="timeline-body">
              <div class="timeline-meta">
                <div   class="d-flex   flex-column px-2 py-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-2 text-md-end">
                  <span class="bold">02/25/24 01:35 PM</span>
                  <span>Asia/Dhaka</span></div>
              </div>
              <div class="timeline-content timeline-indicator">
                <div class="card border-0 shadow">
                  <div class="card-body p-xl-4">
					<div class="row">
					<h2 class="col-8 card-title mb-2  bold" style="font-size: 24px !important;">Event Setup</h2>
				    
					<button class="btn-task-add btn1 col-3 card-title mb-2">Add Task</button>
					</div>
					<div class="row">
						<div class="col-4"></div>
						 <div class="col-6 row">
                             <div   class="col-5">
								<p class="bold" style="font-size:18px !important;">0</p>
								<p class="bold" style="font-size:18px !important;">Tasks</p>
							 </div>
                             <div   class="col-7">
								<p class="bold" style="font-size:18px !important;">0</p>
								<p class="bold" style="font-size:18px !important;">Comments</p>
							 </div>
						 </div>
						<div class="col-2"></div>
					</div>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="timeline-item">
            <div class="timeline-body">
              <div class="timeline-meta">
                <div   class="d-flex   flex-column px-2 py-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-2 text-md-end">
                  <span class="bold">02/25/24 01:35 PM</span>
                  <span>Asia/Dhaka</span>                </div>
              </div>
              <div class="timeline-content timeline-indicator">
                <div class="card border-0 shadow">
                  <div class="card-body p-xl-4">
					<div class="row">
					<h2 class="col-8 card-title mb-2  bold" style="font-size: 24px !important;">RFQ</h2>
				    
					<button class="btn-task-add btn1 col-3 card-title mb-2">Add Task</button>
					</div>
					<div class="row">
						<div class="col-4"></div>
						 <div class="col-6 row">
                             <div   class="col-5">
								<p class="bold" style="font-size:18px !important;">0</p>
								<p class="bold" style="font-size:18px !important;">Tasks</p>
							 </div>
                             <div   class="col-7">
								<p class="bold" style="font-size:18px !important;">0</p>
								<p class="bold" style="font-size:18px !important;">Comments</p>
							 </div>
						 </div>
						<div class="col-2"></div>
					</div>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="timeline-item">
            <div class="timeline-body">
              <div class="timeline-meta">
                <div   class="d-flex   flex-column px-2 py-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-2 text-md-end">
                  <span class="bold">02/25/24 01:35 PM</span>
                  <span>Asia/Dhaka</span>                </div>
              </div>
              <div class="timeline-content timeline-indicator">
                <div class="card border-0 shadow">
                  <div class="card-body p-xl-4">
					<div class="row">
					<h2 class="col-8 card-title mb-2  bold" style="font-size: 24px !important;">Evaluation</h2>
				    
					<button class="btn-task-add btn1 col-3 card-title mb-2">Add Task</button>
					</div>
					<div class="row">
						<div class="col-4"></div>
						 <div class="col-6 row">
                             <div   class="col-5">
								<p class="bold" style="font-size:18px !important;">0</p>
								<p class="bold" style="font-size:18px !important;">Tasks</p>
							 </div>
                             <div   class="col-7">
								<p class="bold" style="font-size:18px !important;">0</p>
								<p class="bold" style="font-size:18px !important;">Comments</p>
							 </div>
						 </div>
						<div class="col-2"></div>
					</div>
                  </div>
                </div>
              </div>
            </div>
          </li>
        </ul>

      </div>
    </div>
  </div>
</section>
         
	
  </div>