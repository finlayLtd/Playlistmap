<div class="modal fade modal-fixed-right modal-theme overflow-hidden" id="settings-modal" tabindex="-1" role="dialog" aria-labelledby="settings-modal-label" aria-hidden="true" data-options='{"autoShow":true,"autoShowDelay":3000,"showOnce":true}'>
    <div class="modal-dialog modal-dialog-vertical" role="document">
        <div class="modal-content border-0 vh-100 scrollbar">
            <div class="modal-header modal-header-settings">
                <div class="z-index-1 py-1">
                    <h5 class="text-white" id="settings-modal-label"> <span class="fas fa-palette mr-2 fs-0"></span>Settings</h5>
                    <p class="mb-0 fs--1 text-white opacity-75"> Set your own customized style</p>
                </div>
                <button class="btn-close btn-close-white z-index-1 mt-0" type="button" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-card">
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-start"><img class="mr-2" src="frontend/img/icons/left-arrow-from-left.svg" width="20" alt="" />
                        <div class="flex-1">
                            <h5 class="fs-0">RTL Mode</h5>
                            <p class="fs--1 mb-0">Switch your language direction </p>
                        </div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input ml-0" id="mode-rtl" type="checkbox" data-home-url="index.html" data-page-url="documentation/RTL.html" />
                    </div>
                </div>
                <hr />
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-start"><img class="mr-2" src="frontend/img/icons/arrows-h.svg" width="20" alt="" />
                        <div class="flex-1">
                            <h5 class="fs-0">Fluid Layout</h5>
                            <p class="fs--1 mb-0">Toggle container layout system </p>
                        </div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input ml-0" id="mode-fluid" type="checkbox" data-home-url="index.html" data-page-url="documentation/fluid-layout.html" />
                    </div>
                </div>
                <hr />
                <div class="d-flex align-items-start"><img class="mr-2" src="frontend/img/icons/paragraph.svg" width="20" alt="" />
                    <div class="flex-1">
                        <h5 class="fs-0 d-flex align-items-center">Navigation Position </h5>
                        <p class="fs--1 mb-2">Select a suitable navigation system for your web application </p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="option-navbar-vertical" type="radio" name="navbar" value="vertical" checked="checked" data-page-url="components/navbar/vertical.html" />
                            <label class="form-check-label" for="option-navbar-vertical">Vertical</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="option-navbar-top" type="radio" name="navbar" value="top" data-page-url="components/navbar/top.html" />
                            <label class="form-check-label" for="option-navbar-top">Top</label>
                        </div>
                        <div class="form-check form-check-inline mr-0">
                            <input class="form-check-input" id="option-navbar-combo" type="radio" name="navbar" value="combo" data-page-url="components/navbar/combo.html" />
                            <label class="form-check-label" for="option-navbar-combo">Combo</label>
                        </div>
                    </div>
                </div>
                <hr />
                <h5 class="fs-0 d-flex align-items-center">Vertical Navbar Style</h5>
                <p class="fs--1">Switch between styles for your vertical navbar </p>
                <div class="btn-group btn-block btn-group-navbar-style">
                    <div class="row gx-2">
                        <div class="col-6">
                            <input class="btn-check" id="navbar-style-transparent" type="radio" name="navbarStyle" checked="checked" data-page-url="index.html" value="transparent" />
                            <label class="btn btn-block btn-navbar-style fs--1" for="navbar-style-transparent"> <img class="img-fluid img-prototype" src="frontend/img/generic/default.png" alt="" /><span class="label-text"> Transparent</span></label>
                        </div>
                        <div class="col-6">
                            <input class="btn-check" id="navbar-style-inverted" type="radio" name="navbarStyle" data-page-url="demo/navbar-vertical-inverted.html" value="inverted" />
                            <label class="btn btn-block btn-navbar-style fs--1" for="navbar-style-inverted"> <img class="img-fluid img-prototype" src="frontend/img/generic/inverted.png" alt="" /><span class="label-text"> Inverted</span></label>
                        </div>
                        <div class="col-6">
                            <input class="btn-check" id="navbar-style-card" type="radio" name="navbarStyle" data-page-url="demo/navbar-vertical-card.html" value="card" />
                            <label class="btn btn-block btn-navbar-style fs--1" for="navbar-style-card"> <img class="img-fluid img-prototype" src="frontend/img/generic/card.png" alt="" /><span class="label-text"> Card</span></label>
                        </div>
                        <div class="col-6">
                            <input class="btn-check" id="navbar-style-vibrant" type="radio" name="navbarStyle" data-page-url="demo/navbar-vertical-vibrant.html" value="vibrant" />
                            <label class="btn btn-block btn-navbar-style fs--1" for="navbar-style-vibrant"> <img class="img-fluid img-prototype" src="frontend/img/generic/vibrant.png" alt="" /><span class="label-text"> Vibrant</span></label>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5"><img class="mb-4" src="frontend/img/illustrations/settings.png" alt="" width="120" />
                    <h5>Like What You See?</h5>
                    <p class="fs--1">Get Falcon now and create beautiful dashboards with hundreds of widgets.</p><a class="btn btn-primary" href="https://themes.getbootstrap.com/product/falcon-admin-dashboard-webapp-template/" target="_blank">Purchase</a>
                </div>
            </div>
        </div>
    </div>
</div>
