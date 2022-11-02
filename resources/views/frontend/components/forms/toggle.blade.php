<div class="toggle-wrapper {{$class ?? ""}}" id="{{$id ?? ""}}">
    <label class="switch">
        <input type="checkbox"  name="{{$name ?? ""}}">
        <span class="slider round"></span>
        <i class="check-icon fa-solid fa-check"></i>
    </label>
</div>


<style>

    .toggle-wrapper .switch {
        position: relative;
        display: inline-block;
        width: 38px;
        height: 24px;
    }

    /* Hide default HTML checkbox */
    .toggle-wrapper .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .toggle-wrapper .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        -webkit-transition: .4s;
        transition: .4s;

        background: transparent;
        border: 1px solid #C0C0C0;
    }

    .toggle-wrapper .slider:before {
        position: absolute;
        content: "";
        height: 15px;
        width: 15px;
        left: 4px;
        bottom: 4px;
        background: #827F7F;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .toggle-wrapper .check-icon{
        display: none;
        position: absolute;
        left: 20px;
        top: 8px;
        margin: auto;
        font-style: normal;
        font-weight: 900;
        font-size: 10px;
        letter-spacing: -0.0044em;
        color: #121212;
        z-index: 100;
        cursor: pointer;
        pointer-events: none;
    }

    .toggle-wrapper input:checked + .slider {
        border: none;
        background: #121212;
    }

    .toggle-wrapper input:focus + .slider {
        /*box-shadow: 0 0 1px #2196F3;*/
    }

    .toggle-wrapper input:checked + .slider:before {
        -webkit-transform: translateX(13px);
        -ms-transform: translateX(13px);
        transform: translateX(13px);
        background: #5EFF5A;
        cursor: pointer;
    }

    .toggle-wrapper input:checked ~ .check-icon{
        display: block;

    }

    .toggle-wrapper .slider.round {
        border-radius: 12px;
    }

    .toggle-wrapper .slider.round:before {
        border-radius: 50%;
    }
</style>