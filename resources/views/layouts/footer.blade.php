<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<footer class="main-footer">
    <strong>
        Copyright &copy; {{ date('Y') }}
        <a href="https://adminlte.io">{{ $title ?? '' }}</a>.
    </strong> All rights reserved.
</footer>

<!-- Modal Logout -->
<div class="modal fade" id="modalLogout" tabindex="-1" role="dialog" aria-labelledby="modalLogoutLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ url('logout') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLogoutLabel">Konfirmasi Logout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah kamu yakin ingin logout dari sistem?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Logout</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/js/adminlte.min.js') }}"></script>

<!-- CUSTOM SCRIPT -->
@yield('customJs')
@yield('bodyJs')

<script>
    setTimeout(() => {
        const toast = document.getElementById('liveToast');
        if (toast) {
            toast.classList.remove('show');
            toast.classList.add('fade');
            setTimeout(() => toast.remove(), 500);
        }
    }, 3000);
</script>
<script type="text/javascript" id="MathJax-script" async
  src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js">
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.MathJax) {
            MathJax.typesetPromise();
        }
    });
</script>
</body>
</html>
