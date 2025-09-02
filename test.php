<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Multiple Choice Row Layout</title>
    <style>
    .wheel-container {
        position: relative;
        width: 300px;
        height: 300px;
        margin: 50px auto;
    }

    .wheel {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        position: relative;
        overflow: hidden;
        border: 5px solid #333;
        box-shadow: 0 0 0 5px #fff, 0 0 0 10px #333;
        transition: transform 5s cubic-bezier(0.17, 0.67, 0.12, 0.99);
    }

    .section {
        position: absolute;
        width: 50%;
        height: 50%;
        background: var(--clr);
        transform-origin: bottom right;
        transform: rotate(calc(60deg * var(--i)));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: bold;
        color: #fff;
        text-shadow: 1px 1px 1px #000;
    }

    .pointer {
        position: absolute;
        top: -20px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 15px solid transparent;
        border-right: 15px solid transparent;
        border-top: 30px solid #ff0000;
        z-index: 10;
    }

    #spin-btn {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    #spin-btn:hover {
        background: #45a049;
    }
    </style>
</head>

<body>

    <div class="wheel-container">
        <div class="wheel">
            <div class="section" style="--i:1; --clr:#ff0000;">1</div>
            <div class="section" style="--i:2; --clr:#ff9900;">2</div>
            <div class="section" style="--i:3; --clr:#ffff00;">3</div>
            <div class="section" style="--i:4; --clr:#00ff00;">4</div>
            <div class="section" style="--i:5; --clr:#0099ff;">5</div>
            <div class="section" style="--i:6; --clr:#0000ff;">6</div>
        </div>
        <div class="pointer"></div>
        <button id="spin-btn">လှည့်ရန်</button>
    </div>

    <script>
    const wheel = document.querySelector('.wheel');
    const spinBtn = document.getElementById('spin-btn');
    let deg = 0;

    spinBtn.addEventListener('click', () => {
        spinBtn.disabled = true;
        deg = Math.floor(5000 + Math.random() * 5000);
        wheel.style.transform = `rotate(${deg}deg)`;

        setTimeout(() => {
            spinBtn.disabled = false;
            // ဘယ်အပိုင်းမှာရပ်လဲဆိုတာကို တွက်ချက်နိုင်ပါတယ်
            const actualDeg = deg % 360;
            const section = Math.floor(actualDeg / 60); // 6 ပိုင်းဆိုရင် 60 degree တစ်ပိုင်း
            alert(`ရလဒ်: ${section}`);
        }, 5000);
    });
    </script>

</body>

</html>