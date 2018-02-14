<main class="main-content bgc-grey-100">
	<div id="mainContent">
        <div class="row gap-20 masonry pos-r">
            <div class="masonry-sizer"></div>
                <div class="masonry-item col-md-3">
                    <div class="bgc-white p-20 bd">
                        <h5 class="c-grey-900"><i class="ti-user"></i> Employee Management</h5>
                        <a href="<?= site_url('people/employee') ?>" class="btn btn-sm btn-primary"> Show Data</a>
                    </div>
                </div>
                <div class="masonry-item col-md-6">
                    <div class="bgc-white p-20 bd">
                        <h5 class="c-grey-900">Add Data</h5>
                        <small class="text-muted">Please enter the complete data!</small>
                        <div class="mT-30">
                            <form class="container" id="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">NIK</label>
                                        <input type="text" name="c_people" class="form-control" id="validationCustom01" placeholder="Nomor Induk" value="" required>
                                        <div class="invalid-feedback">Please provide a valid nik.</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom02">Full Name</label>
                                        <input type="text" name="n_people" class="form-control" id="validationCustom02" placeholder="Full Name" value="" required>
                                        <div class="invalid-feedback">Please provide a valid full name.</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label>Type</label>
                                        <select name="type_people" class="form-control" require>
                                            <option value="employee">Employee</option>
                                            <option value="non employee">Non Employee</option>
                                            <option value="tenant">Tenant/Vendor</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label>Company</label>
                                        <select name="c_company" class="form-control" require>
                                            <option value="NI">Nutech Integrasi</option>
                                            <option value="TEL">Telkom</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom03">Email</label>
                                        <input type="email" class="form-control" id="validationCustom03" placeholder="Email" required>
                                        <div class="invalid-feedback">Please provide a valid email.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom04">Phone</label>
                                        <input type="text" class="form-control" id="validationCustom04" placeholder="Phone" required>
                                        <div class="invalid-feedback">Please provide a valid phone.</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label>Status</label>
                                        <select name="b_active" class="form-control" require>
                                            <option value="t">Aktif</option>
                                            <option value="f">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-danger" type="submit">Save Data</button>
                            </form>
                            <script>
                                ! function () {
                                    "use strict";
                                    window.addEventListener("load", function () {
                                        var t = document.getElementById("needs-validation");
                                        t.addEventListener("submit", function (e) {
                                            !1 === t.checkValidity() && (e.preventDefault(), e.stopPropagation()), t.classList.add(
                                                "was-validated")
                                        }, !1)
                                    }, !1)
                                }()

                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
