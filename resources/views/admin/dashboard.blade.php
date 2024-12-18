@extends('Admin.layouts.app')
@section('title', 'Trang Quản Trị')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Bảng Điều Khiển</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        

    </div><!-- /.container-fluid -->
</section>
@endsection
@section('script')
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function(){
      $.get('', function(data){
        var months = ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"];
        var order = data;

        // Lấy thẻ canvas
        var ctx = document.getElementById('orderChar').getContext('2d');

        // Khởi tạo biểu đồ đường
        var orderChar = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Đơn Hàng Theo Tháng',
                    data: order,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                scales: {
                  y: {
                      beginAtZero: true,
                      ticks: {
                          stepSize: 1, // Đảm bảo chỉ hiển thị số nguyên
                          callback: function(value, index, values) {
                              return Math.round(value); // Làm tròn giá trị
                          }
                      }
                  }
              }
            },
        });
      })

    $.get('', function(data){
        // Dữ liệu doanh thu theo tháng
        var months = ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"];
        var revenues = data;

        // Lấy thẻ canvas
        var ctx = document.getElementById('revenueChart').getContext('2d');

        // Khởi tạo biểu đồ đường
        var revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Doanh thu theo tháng (VND)',
                    data: revenues,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
            });
        })
    });
</script> -->
@endsection