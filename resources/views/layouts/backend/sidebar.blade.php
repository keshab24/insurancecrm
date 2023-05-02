
<div class="fixed">
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu" style="height: 100vh; overflow-x: hidden; overflow-y: scroll;" data-widget="tree">
                {{-- Dashboard --}}
                <li>
                    <a href="{{ route('dashboard') }}" id="dashboard">
                        <i class="fa fa fa-tachometer"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                {{-- Leads ( List of Customers ) of Respective User Related --}}
                @if(control('create-leads'))
                <li>
                    <a href="{{ route('admin.leads.customers') }}">
                        <i class="fa fa-users"></i>
                        <span>Customers</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.leads.index') }}">
                        <i class="fa fa-user-circle"></i>
                        <span>Leads</span>
                    </a>
                </li>
                @endif
                {{-- End of Leads ( List of Customers ) of Respective User Related --}}

                {{-- Calendar --}}
                @if(control('create-calender'))
                <li class="treeview">
                    <a href="javascript:void(0);" id="" class="menu-toggle">
                        <i class="fa fa-calendar-o"></i>
                        <span>Calendar</span>

                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>

                    </a>

                    <ul class="treeview-menu">
                        <li id="dashboard">
                            <a href="{{ route('admin.calender.meeting') }}">
                                <i class="fa fa-calendar-o"></i>Meeting Calendar
                            </a>
                        </li>
                        <li id="dashboard">
                            <a href="{{ route('admin.calender.event') }}">
                                <i class="fa fa-calendar-o"></i>Remarks Calendar
                            </a>
                        </li>

                    </ul>
                </li>
                @endif
                {{-- End of Calendar --}}
                {{-- Compare Policy --}}
                <li>
                    <a href="{{ route('admin.policy.form') }}">
                        <i class="fa fa-calculator"></i>
                        <span>Compare Policy</span>
                    </a>
                </li>

                {{-- End of Compare Policy --}}

                {{-- Life Calculator --}}
                {{--                {{dd(json_decode(Auth::user()->company_details))}}--}}
                @if(control('premium-calculation'))
                @if(in_array('Life',AgentCat()) || in_array('all',AgentCat()))
                <li>
                    <a href="{{ route('calculator.life.calculate') }}">
                        <i class="fa fa-calculator"></i>
                        <span>Life Calculator</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('selected.plans') }}">
                        <i class="fa fa-calculator"></i>
                        <span>Plan Selected</span>
                    </a>
                </li>
                @endif
                {{-- End of Life Calculator --}}
                {{-- Non Life Calculator --}}
                {{--                    {{dd(AgentCat())}}--}}
                @if(in_array('NonLife',AgentCat()) || in_array('all',AgentCat()))
                <li class="treeview">
                    <a href="javascript:void(0);" id="" class="menu-toggle">
                        <i class="fa fa-calculator"></i>
                        <span>Non Life Calculator</span>

                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>

                    </a>

                    <ul class="treeview-menu">
                        <li id="dashboard">
                            <a href="{{ route('nonLife.calculator.bike',['classId'=>'21']) }}">
                                <i class="fa fa-motorcycle"> </i> Motor Cycle
                            </a>
                        </li>
                        <li id="dashboard">
                            <a href="{{ route('nonLife.calculator.car',['classId'=>'23']) }}">
                                <i class="fa fa-car"> </i> Private Vehicle
                            </a>
                        </li>
                        <li id="dashboard">
                            <a href="{{ route('nonLife.calculator.commercial.car',['classId'=>'22']) }}">
                                <i class="fa fa-bus"> </i> Commercial Vehicle
                            </a>
                        </li>
                    </ul>

                </li>
                @endif
                {{-- End of Non Life Calculator --}}
                @endif
                @if(control('travel-calculation'))
                    <li class="treeview">
                        <a href="javascript:void(0);" id="" class="menu-toggle">
                            <i class="fa fa-plane"></i>
                            <span>Travel Calculator</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>

                        </a>

                        <ul class="treeview-menu">
                            <li id="dashboard">
                                <a href="{{ route('travel.calculator.insurance.index') }}">
                                    <i class="fa fa-plane"> </i> Travel Medical Insurance
                                </a>
                            </li>
                        </ul>

                    </li>
                @endif
                @if(control('premium-calculation'))
                @if(in_array('Life',AgentCat()) || in_array('all',AgentCat()))
                <li>
                    <a href="{{ route('admin.ime.life.insurance') }}">
                        <i class="fa fa-calculator"></i>
                        <span>IME Life</span>
                    </a>
                </li>
                {{-- End of Life Calculator --}}
                @endif
                @endif
                {{-- Admin Settings --}}
                @if(control('frontend-dynamics'))
                <li class="treeview">
                    <a href="javascript:void(0);" id="" class="menu-toggle">
                        <i class="fa fa-cogs"></i>
                        <span>Admin Settings</span>

                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        {{-- Loading Charge --}}
                        <li id="dashboard">
                            <a href="{{ route('loadingcharges.create') }}" id="dashboard">
                                <i class="fa fa fa-credit-card-alt"></i>
                                <span>Loading Charges</span>
                            </a>
                        </li>

                        <li id="dashboard">
                            <a href="{{ route('crcrate.create') }}" id="dashboard">
                                <i class="fa fa fa-credit-card-alt"></i>
                                <span>CRC Rate</span>
                            </a>
                        </li>
                        {{-- End of Loading Charge --}}

                        {{-- Lead Related --}}
                        @if(control('create-leads'))
                        <li class="treeview">
                            <a href="javascript:void(0);" id="" class="menu-toggle">
                                <i class="fa fa-tags"></i>
                                <span>Lead Related</span>

                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>

                            </a>

                            <ul class="treeview-menu">
                                <li id="">
                                    <a href="{{ route('admin.leadcategories.leadsource.index') }}">
                                        Lead Source
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('admin.leadcategories.leadtypes.index')}}" id="permission">
                                        Lead Types
                                    </a>
                                </li>
                            </ul>

                        </li>
                        @endif
                        {{-- End of Lead Related --}}

                        {{-- Policy Categories  --}}
                        @if(control('create-policy'))
                        <li class="treeview">
                            <a href="javascript:void(0);" id="" class="menu-toggle">
                                <i class="fa fa-pause-circle"></i>
                                <span>Policy Categories </span>

                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>

                            </a>

                            <ul class="treeview-menu">
                                <li id="">
                                    <a href="{{ route('admin.policycategories.sub.index') }}">
                                        Policy Sub Categories
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('admin.policycategories.type.index')}}" id="permission">
                                        Policy Types
                                    </a>
                                </li>
                            </ul>

                        </li>
                        @endif
                        {{-- End of Policy Categories  --}}

                        {{-- User Management --}}
                        @if(control('create-user'))
                        <li class="treeview">
                            <a href="javascript:void(0);" id="" class="menu-toggle">
                                <i class="fa fa-users"></i>
                                <span>User Management</span>

                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>

                            </a>

                            <ul class="treeview-menu">
                                <li id="">
                                    <a href="{{ route('admin.privilege.role.index') }}">
                                        <i class="fa fa-users"></i>Role
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('admin.privilege.permission.index')}}" id="permission">
                                        <i class="fa fa fa-cog"></i>
                                        <span>Permission</span>
                                    </a>
                                </li>
                                <li id="">
                                    <a href="{{ route('admin.privilege.user.index') }}">
                                        <i class="fa fa-user"></i>User
                                    </a>
                                </li>
                            </ul>

                        </li>
                        @endif
                        {{-- End of User Management --}}

                        {{-- Company Management --}}
                        @if(control('create-company'))
                        <li>
                            <a href="{{ route('companies.index') }}" id="dashboard">
                                <i class="fa fa fa-building"></i>
                                <span>Company Managemrnt</span>
                            </a>
                        </li>
                        @endif
                        {{-- End of Company Management --}}
                        {{-- Product Management --}}
                        @if(control('create-product'))
                        <li id="dashboard">
                            <a href="{{ route('admin.product.list') }}">
                                <i class="fa fa-th-large"></i>
                                <span>Product Management</span>
                            </a>
                        </li>


                        @endif

                        @if(control('create-product'))
                        <li class="treeview">
                            <a href="javascript:void(0);" id="" class="menu-toggle">
                                <i class="fa fa-pause-circle"></i>
                                <span>Features </span>

                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>

                            </a>

                            <ul class="treeview-menu">
                                <li id="">
                                    <a href="{{ route('admin.feature.list') }}">
                                        Feature Management
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('admin.feature.product')}}" id="permission">
                                        Feature Products
                                    </a>
                                </li>
                            </ul>

                        </li>
                        @endif


                        {{-- End of Product Management --}}

                        @if(control('premium-calculation'))

                        {{-- Discount on SA --}}
                        <li id="dashboard">
                            <a href="{{ route('admin.discount.list') }}">
                                <i class="fa fa-percent"></i>Discount on SA
                            </a>
                        </li>
                        {{-- End of Discount on SA --}}

                        {{-- Bonus --}}
                        <li id="dashboard">
                            <a href="{{ route('admin.bonus.list') }}">
                                <i class="fa fa-dollar"></i>Bonus
                            </a>
                        </li>
                        {{-- End of Bonus --}}

                        {{-- Loading Charge --}}
                        <li>
                            <a href="{{ route('loadingcharges.create') }}" id="dashboard">
                                <i class="fa fa fa-credit-card-alt"></i>
                                <span>Loading Charges</span>
                            </a>
                        </li>
                        {{-- End of Loading Charge --}}

                        {{-- Payback Schedule --}}
                        <li>
                            <a href="{{ route('admin.payback.index') }}" id="dashboard">
                                <i class="fa fa fa-money"></i>
                                <span>Payback Schedule</span>
                            </a>
                        </li>
                        {{-- End of Payback Schedule --}}

                        {{-- Couple Age Difference --}}
                        <li>
                            <a href="{{ route('age-difference.index') }}" id="dashboard">
                                <i class="fa fa fa-minus"></i>
                                <span>Couple's Age Difference</span>
                            </a>
                        </li>
                        {{-- End of Couple Age Difference --}}

                        {{-- Paying Term --}}
                        <li>
                            <a href="{{ route('paying-term.index') }}" id="dashboard">
                                <i class="fa fa fa-money"></i>
                                <span>Policy Paying Term</span>
                            </a>
                        </li>
                        {{-- End of Paying Term --}}
                        @endif
                        {{-- Product Data Management --}}
                        @if(control('rate-import'))
                        <li class="treeview">
                            <a href="javascript:void(0);" id="" class="menu-toggle">
                                <i class="fa fa-table"></i>
                                <span>Rate Table (Product Data Management)</span>

                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>

                            </a>

                            <ul class="treeview-menu">

                                <li id="">
                                    <a href="{{ route('rate.feature.index') }}">
                                        <i class="fa fa-calendar-o"></i>Product Features rate
                                    </a>
                                </li>
                                <li id="">
                                    <a href="{{ route('endowment.rate.index') }}">
                                        <i class="fa fa-calendar-o"></i>Table rate
                                    </a>
                                </li>
                            </ul>

                        </li>
                        @endif
                        {{-- End of Product Data Management --}}

                        {{-- General Settings --}}
                        @if(control('frontend-dynamics'))
                        <li>
                            <a href="{{ route('general-setting.index') }}">
                                <i class="fa fa fa-cog"></i>
                                <span>General Settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('api-key.index')}}" id="dashboard">
                                <i class="fa fa fa-key"></i>
                                <span>Api Key</span>
                            </a>
                        </li>
                        @endif
                        {{-- End of General Settings --}}

                    </ul>
                </li>
                @endif
                {{-- End of Admin Settings --}}

                {{-- Frontend Settings --}}

                @if(control('frontend-dynamics'))
                <li class="treeview">
                    <a href="javascript:void(0);" id="" class="menu-toggle">
                        <i class="fa fa-tasks"></i>
                        <span>Frontend Settings</span>

                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>

                    </a>

                    <ul class="treeview-menu">
                        {{-- Home Page --}}
                        <li class="treeview">
                            <a href="javascript:void(0);" id="" class="menu-toggle">
                                <i class="fa fa-home"></i>
                                <span>Home Page</span>

                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>

                            </a>

                            <ul class="treeview-menu">
                                <li id="">
                                    <a href="{{ route('why-us.index') }}">
                                        <i class="fa fa-handshake-o"></i>
                                        <span>Why Us</span>
                                    </a>
                                </li>
                                <li id="">
                                    <a href="{{ route('why-different.index') }}">
                                        <i class="fa fa-th-large"></i>
                                        <span>Why Different</span>
                                    </a>
                                </li>
                                <li id="">
                                    <a href="{{ route('testimonial.index') }}" id="testimonial">
                                        <i class="fa fa-quote-left"></i>
                                        <span>Testimonials</span>
                                    </a>
                                </li>
                                <li id="">
                                    <a href="{{ route('association.index') }}">
                                        <i class="fa fa-handshake-o"></i>
                                        <span>Our Association</span>
                                    </a>
                                </li>
                            </ul>

                        </li>
                        {{-- End of Home Page --}}

                        {{-- About Us Page --}}
                        <li class="treeview">
                            <a href="javascript:void(0);" id="" class="menu-toggle">
                                <i class="fa fa-info-circle"></i>
                                <span>About Us Page</span>

                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>

                            </a>

                            <ul class="treeview-menu">
                                <li id="">
                                    <a href="{{ route('about-us.index') }}">
                                        <i class="fa fa-info"></i>
                                        <span>About Us</span>
                                    </a>
                                </li>

                                <li id="">
                                    <a href="{{ route('values.index') }}">
                                        <i class="fa fa-handshake-o"></i>
                                        <span>Core Values</span>
                                    </a>
                                </li>

                                <li id="">
                                    <a href="{{ route('team.index')}}" id="testimonial">
                                        <i class="fa fa-users"></i>
                                        <span>Teams</span>
                                    </a>
                                </li>

                            </ul>

                        </li>
                        {{-- End of About Us Page --}}

                        {{-- Contact Us Page --}}
                        <li class="treeview">
                            <a href="javascript:void(0);" id="" class="menu-toggle">
                                <i class="fa fa-phone-square"></i>
                                <span>Contact Us Page</span>

                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>

                            </a>

                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{ route('admin.message.index') }}" id="dashboard">
                                        <i class="fa fa fa-envelope"></i>
                                        <span>Client's Messages</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('general-setting.contact') }}">
                                        <i class="fa fa fa-cog"></i>
                                        <span>Contact Settings</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- End of Contact Us Page --}}

                        {{-- Social Media --}}
                        <li>
                            <a href="{{ route('social-link.index') }}" id="dashboard">
                                <i class="fa fa fa-link"></i>
                                <span>Social Media Links</span>
                            </a>
                        </li>
                        {{-- End of Social Media --}}

                    </ul>
                </li>
                @endif

                <li>
                    <a href="{{route('nonLife.calculator.policy.view')}}" id="dashboard">
                        <i class="fa fa fa-link"></i>
                        <span>Policies</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('nonLife.calculator.draft.policy.view')}}" id="dashboard">
                        <i class="fa fa fa-link"></i>
                        <span>Draft Policies</span>
                    </a>
                </li>
                {{-- End of Frontend Settings --}}

                {{-- old menu --}}
                <br>
                <hr>
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>
</div>
`
