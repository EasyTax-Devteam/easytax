@extends('layouts.inner')

@section('navigation')
    @include('inner.nav', ['active' => [0,0,'active', 0,0,0,0,0]])
@endsection


@section('content')

@if( \Auth::user()->admin == 1 )
	<div class="app-content pt-3 p-md-3 p-lg-4">
		<div class="container-xl">
			
		</div>
	</div>
@endif


@if( \Auth::user()->root == 1)
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
      <div class="position-relative mb-3">
        <div class="row g-3 justify-content-between">
          <div class="col-auto">
            <h1 class="app-page-title mb-0"><a href="{{ route('e.tax.orders') }}">Orders</a> > Order #12345 </h1>
          </div>
          <div class="col-auto">
            <div class="page-utilities"></div>
          </div>
        </div>
      </div>
      <div class="app-card app-card-notification shadow-sm mb-4">
        <div class="app-card-header px-4 py-3">
          <div class="row g-3 align-items-center">
            <!--//col-->
            <div class="col-md-5">
              <div class="notification-type mb-2">
                <span class="badge bg-info">Order #12345</span>
              </div>
              <h4 class="notification-title mb-1">Service: Digital Tax returns</h4>
              <ul class="notification-meta list-inline mb-0">
                <li class="list-inline-item">@ 12:45 pm</li>
                <li class="list-inline-item">|</li>
                <li class="list-inline-item">Amy Doe</li>
              </ul>
            </div>
            <div class="col-md-6 col-lg-auto text-center">
                <form class="row" method="post" action="{{ route('e.tax.update.settings') }}">
                    <div class="col-md-4 mr-2">
                        {{ $assigned ? 'Assigned' : 'Assign'}} To<br>
                        <span class="badge {{ $assigned ? 'bg-success' : 'bg-danger'}}">{{ $assigned ? 'already assigned' : 'not assigned'}}</span>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select form-select-sm w-auto">
                            <option value="">Assigned to...</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn app-btn-primary">assign </button>
                    </div>
                </form>
            </div>
            <!--//col-->
          </div>
          <!--//row-->
        </div>
        <!--//app-card-header-->
        <div class="app-card-body p-4">
            <h4 class="notification-title mb-1">Customer personal information</h4>
            <div class="notification-content">
                <div class="col-auto">
                    <div class="item-label"><strong>Full Name </strong></div>
                    <div class="item-data">Amy Doe</div>
                    <br>
                </div>
                <div class="col-auto">
                    <div class="item-label"><strong>Email Address </strong></div>
                    <div class="item-data">Amy.Doe@gmail.com</div>
                    <br>
                </div>
                <div class="col-auto">
                    <div class="item-label"><strong>Phone number </strong></div>
                    <div class="item-data">+254706556556</div>
                    <br>
                </div>
            </div>
            <hr>
            <h4 class="notification-title mb-1">Customer KRA information</h4>
            <div class="notification-content">
                <div class="col-auto">
                    <div class="item-label"><strong>KRA PIN number </strong></div>
                    <div class="item-data">A007345609K</div>
                    <br>
                </div>
                <div class="col-auto">
                    <div class="item-label"><strong>KRA iTax Password </strong></div>
                    <div class="item-data">Amy23Doe2021</div>
                    <br>
                </div>
                <div class="col-auto">
                    <div class="item-label"><strong>Had Taxable Income </strong></div>
                    <div class="item-data">Yes</div>
                    <br>
                </div>
                <div class="col-auto">
                    <div class="item-label"><strong>Personally pays Kenyan insurance policies </strong></div>
                    <div class="item-data">No</div>
                    <br>
                </div>
                <div class="col-auto">
                    <div class="item-label"><strong>Kenyan Insurance policies </strong></div>
                    <div class="item-data">Life, Medical, Education with 10 year terms</div>
                    <br>
                </div>
                <div class="col-auto">
                    <div class="item-label"><strong>Paid Kenyan Bank Mortgage for the year of income </strong></div>
                    <div class="item-data">No</div>
                    <br>
                </div>
                <div class="col-auto">
                    <div class="item-label"><strong>P9 Attachment </strong></div>
                    <div class="item-data">
                        <br>
                        <div class="app-card app-card-doc shadow-sm" style="width: 200px;">
                            <div class="app-card-thumb-holder p-3">
                                <span class="icon-holder">
                                <svg class="svg-inline--fa fa-file-alt fa-w-12 text-file" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="file-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M224 136V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zm64 236c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12v8zm0-64c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12v8zm0-72v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12zm96-114.1v6.1H256V0h6.1c6.4 0 12.5 2.5 17 7l97.9 98c4.5 4.5 7 10.6 7 16.9z"></path>
                                </svg>
                                </span>
                                <a class="app-card-link-mask" href="#file-link"></a>
                            </div>
                            <div class="app-card-body p-3 has-card-actions">
                                <h4 class="app-doc-title truncate mb-0"> 
                                    <a href="#file-link">P9-pdf-file-attachement.docx</a>
                                </h4>
                                <div class="app-doc-meta"></div>
                                <div class="app-card-actions">
                                    <div class="dropdown">
                                        <div class="dropdown-toggle no-toggle-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"></path>
                                        </svg>
                                        </div>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                                    <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                                </svg>Download </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>

                <div class="col-auto">
                    <div class="item-label"><strong>Income and Expenses Schedule </strong></div>
                    <div class="item-data">
                        <br>
                        <div class="app-card app-card-doc shadow-sm" style="width: 200px;">
                            <div class="app-card-thumb-holder p-3">
                                <span class="icon-holder">
                                <i class="fas fa-file-excel excel-file"></i>
                                </span>
                                <a class="app-card-link-mask" href="#file-link"></a>
                            </div>
                            <div class="app-card-body p-3 has-card-actions">
                                <h4 class="app-doc-title truncate mb-0"> 
                                    <a href="#file-link">Income-and-Expenses.xlsx</a>
                                </h4>
                                <div class="app-doc-meta"></div>
                                <div class="app-card-actions">
                                    <div class="dropdown">
                                        <div class="dropdown-toggle no-toggle-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"></path>
                                        </svg>
                                        </div>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                                    <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                                </svg>Download </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>

            <hr>

            <h4 class="notification-title mb-1">Company information</h4>
            <div class="notification-content">
                <div class="col-auto">
                    <div class="item-label"><strong>Company Name </strong></div>
                    <div class="item-data">Amy Doe LLP</div>
                    <br>
                </div>
                <div class="col-auto">
                    <div class="item-label"><strong>Company Email Address </strong></div>
                    <div class="item-data">Amy.Doe@gmail.com</div>
                    <br>
                </div>
                <div class="col-auto">
                    <div class="item-label"><strong>Phone number </strong></div>
                    <div class="item-data">+254706556556</div>
                    <br>
                </div>

                <div class="col-auto">
                    <div class="item-label"><strong>Company KRA PIN </strong></div>
                    <div class="item-data">+P55555fg</div>
                    <br>
                </div>

                <div class="col-auto">
                    <div class="item-label"><strong>iTax Password </strong></div>
                    <div class="item-data">+P55555fg</div>
                    <br>
                </div>

                <div class="col-auto">
                    <div class="item-label"><strong>Financial Statements </strong></div>
                    <br>
                    <div class="item-data">
                        <!-- begin statements -->
                        <div class="row g-4">
                            <div class="col-6 col-md-4 col-xl-3 col-xxl-2">
                                <div class="app-card app-card-doc shadow-sm h-100">
                                    <div class="app-card-thumb-holder p-3">
                                        <span class="icon-holder">
                                        <i class="fas fa-file-excel excel-file"></i>
                                        </span>
                                        <a class="app-card-link-mask" href="#file-link"></a>
                                    </div>
                                    <div class="app-card-body p-3 has-card-actions">
                                        <h4 class="app-doc-title truncate mb-0">
                                            <a href="#file-link">
                                                <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;">Doc</font>
                                                </font>
                                            </a>
                                        </h4>
                                        <div class="app-card-actions">
                                            <div class="dropdown">
                                                <div class="dropdown-toggle no-toggle-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"></path>
                                                    </svg>
                                                </div>
                                                <ul class="dropdown-menu" style="">
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                                            <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                                        </svg>Download </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-xl-3 col-xxl-2">
                                <div class="app-card app-card-doc shadow-sm h-100">
                                    <div class="app-card-thumb-holder p-3">
                                        <span class="icon-holder">
                                        <i class="fas fa-file-excel excel-file"></i>
                                        </span>
                                        <a class="app-card-link-mask" href="#file-link"></a>
                                    </div>
                                    <div class="app-card-body p-3 has-card-actions">
                                        <h4 class="app-doc-title truncate mb-0">
                                            <a href="#file-link">
                                                <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;">Doc</font>
                                                </font>
                                            </a>
                                        </h4>
                                        <div class="app-card-actions">
                                            <div class="dropdown">
                                                <div class="dropdown-toggle no-toggle-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"></path>
                                                    </svg>
                                                </div>
                                                <ul class="dropdown-menu" style="">
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                                            <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                                        </svg>Download </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  end -->
                    </div>
                    <br>
                </div>
            </div>
            
        </div>
        <!--//app-card-body-->
        <div class="app-card-footer px-4 py-3">
          <a class="action-link" href="{{ route('e.tax.orders') }}">View all <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right ms-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
            </svg>
          </a>
        </div>
      </div>
    </div>
    
    <!--//container-fluid-->
  </div>
@endif
@endsection