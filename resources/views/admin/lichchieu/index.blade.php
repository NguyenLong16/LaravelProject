<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch chiếu</title>
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
</head>
<body>
    @if(Auth::check() && Auth::user()->role == 1)
        <div class="sidebar" id="sidebar">
            <button class="closebtn" onclick="closeNav()">Close</button>
            <div class="user-info">
                <img src="images/admin.png" alt="">
                <p>Hi, {{ explode(' ', Auth::user()->name)[count(explode(' ', Auth::user()->name)) - 1] }}!</p>
                <a href="{{ route('logoutAdmin') }}">Đăng xuất</a>
            </div>
            
            <ul class="menu">
                <li><a href="{{ route('admin.index') }}">Admin</a></li>
                <li><a href="{{ route('phim.index') }}">Quản lý phim</a></li>
                <li><a href="{{ route('theloai.index') }}">Quản lý thể loại</a></li>
                <li><a href="{{ route('lichchieu.index') }}">Quản lý lịch chiếu</a></li>
                <li><a href="{{ route('phongchieu.index') }}">Quản lý phòng chiếu</a></li>
                <li><a href="{{ route('douong.index') }}">Quản lý Đồ Uống</a></li>
                <li><a href="{{ route('loaighe.index') }}">Quản lý Loại ghế</a></li>
                <li><a href="{{ route('methods.index') }}">Quản lý phương thức thanh toán</a></li>
                <li><a href="{{ route('taikhoan.index') }}">Quản lý tài khoản</a></li>
                <li><a href="{{ route('thongke.index') }}">Thống kê doanh thu</a></li>
            </ul>
        </div>
        
        <button class="openbtn" onclick="openNav()">&#9776; Open Sidebar</button>
        <h1 align = center>Xin Chào Admin</h1>
    @else
        <h1 align = center>Xin Chào Admin</h1>
        <p align = center><a class="btn-Login" href="{{ route('login') }}">Đăng nhập</a></p>
    @endif

    <button class="openbtn" onclick="openNav()">&#9776; Open Sidebar</button>
    <div class="container mt-5">
        <h1 class="mb-4">Danh Sách Lịch Chiếu</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))  
            <div class="alert alert-danger">  
                {{ session('error') }}  
            </div>  
        @endif  
        <a href="{{ route('lichchieu.create') }}" class="btn btn-primary">Thêm Lịch Chiếu</a>
        <a href="{{ route('lichchieu.show') }}" class="btn btn-primary">Kích Hoạt</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tên Phim</th>
                    <th>Xuất Chiếu</th>
                    <th>Tên Phòng Chiếu</th>
                    <th>Số Ghế Trống</th>
                    <th>Trạng thái</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lichChieus as $lichChieu)
                    <tr>
                        <td>{{ $lichChieu->movie->TENPHIM }}</td>
                        <td>{{ $lichChieu->XUATCHIEU }}</td>
                        <td>{{ $lichChieu->room->TENPHONGCHIEU }}</td>
                        <td>{{ $lichChieu->available_seats_count }}</td> 
                        <td>{{ $lichChieu->status == 0 ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{ route('lichchieu.edit', $lichChieu->IDLICHCHIEU) }}">Sửa</a>
                        </td>
                        <td>  
                            <form method="POST" action="{{ route('lichchieu.destroy', $lichChieu->IDLICHCHIEU) }}" class="delete-form">  
                                @csrf  
                                @method('DELETE')  
                                <button type="submit" class="btn-delete" data-id="{{ $lichChieu->IDLICHCHIEU }}" >
                                    Xóa  
                                </button>  
                            </form>  
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Không có lịch chiếu nào được hiển thị</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                const button = event.submitter; // Nút đã kích hoạt form submission
                const hasShowtime = button.getAttribute('data-has-showtime') === 'true';
                const row = form.closest('tr'); // Tìm dòng <tr> chứa form

                if (hasShowtime) {
                    // Nếu phim còn lịch chiếu, ngăn gửi form và hiển thị thông báo
                    event.preventDefault(); // Ngăn gửi form
                    alert('Phim vẫn còn lịch chiếu, không thể xóa.');
                } else {
                    if (confirm('Bạn có chắc muốn xóa lịch chiếu này không?')) {
                        row.style.display = 'none'; 
                        form.submit(); 
                    } else {
                        event.preventDefault(); // Nếu người dùng hủy, ngừng gửi form
                    }
                }
            });
        });
    });
</script>
<script>
        function openNav() {
            document.getElementById("sidebar").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("sidebar").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }
    </script>
</body>
</html>
