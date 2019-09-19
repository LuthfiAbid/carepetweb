@extends('dashboard')
@section('sidebar_left')
<div id="sidebar-nav" class="sidebar">
        <div class="sidebar-scroll">
            <nav>
                <ul class="nav">
                    <li class="@yield('admin/home')">
                        <a href="{{ url('admin/home') }}">
                    <i class='fa fa-edit'></i>
                        <span>Home</span>
                        </a>
                    </li>
                    <li class="@yield('admin/data_tarif')">
                        <a href="{{ url('admin/data_tarif') }}">
                    <i class='fa fa-edit'></i>
                        <span>Data Tarif</span>
                        </a>
                    </li>
                    <li class="@yield('admin/dataPelanggan')">
                        <a href="{{ url('admin/dataPelanggan') }}">
                    <i class='fa fa-edit'></i>
                        <span>Data Pelanggan</span>
                        </a>
                    </li>
                    <li class="@yield('admin/dataPelanggan')">
                        <a onclick="logout()">
                    <i class='fa fa-edit'></i>
                        <span>Logout</span>
                        </a>
                    </li>								
                </ul>
            </nav>
        </div>
    </div>
  @endsection