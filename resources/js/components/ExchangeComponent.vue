<template>
    <div class="exchange-component">
        <button class="press-me-btn" @click="showForm"><div>Press me</div></button>

        <div class="exchange-block" v-show="isVisible">
            <div class="animate-plane"></div>
            <form action="/" id="exchange-form">
                <div class="top-exchange">
                    <div class="withdrawal-sum">
                        <label for="withdrawal">Сумма к выводу</label>
                        <input type="text" name="withdrawal" id="withdrawal" v-model="inputSum" v-on:keyup="doInputSum($event.target.value)" @paste.prevent>
                    </div>
                    <div class="currency-change">
                        <label for="currency">Валюта</label>
                        <div class="currency">
                            <select name="currency" id="currency" @change="changeCurrency($event)">
                                <option value="eur">EUR</option>
                                <option value="usd">USD</option>
                                <option value="gbp">GBP</option>
                                <option value="btc">BTC</option>
                            </select>
                        </div>
                    </div>
                    <div class="our-comission">
                        <label for="comission">Наша комиссия</label>
                        <input type="text" name="comission" id="comission" v-bind:value="commission" disabled>
                    </div>
                </div>

                <div class="bottom-exchange">
                    <div class="we-send">
                        <label for="we-send-sum">Мы отправляем</label>
                        <input type="text" name="we-send-sum" id="we-send-sum" v-bind:value="weSendSum" disabled>
                    </div>
                    <div class="currency-change">
                        <label for="crypto">Криптовалюта</label>
                        <div class="currency">
                            <select name="crypto" id="crypto" @change="changeCrypto($event)">
                                <option value="btc">BTC</option>
                                <option value="eur">EUR</option>
                                <option value="usd">USD</option>
                                <option value="gbp">GBP</option>
                            </select>
                        </div>
                    </div>
                    <div class="you-get">
                        <label for="you-get-sum">Вы получаете</label>
                        <input type="text" name="you-get-sum" id="you-get-sum" v-bind:value="getFinalSum" disabled>
                    </div>
                </div>
            </form>
            <div class="ctrl-btns">
                <button class="send" @click="sendMoney">Press me</button>
                <a href="/" class="go-back" @click="goBack">Go back</a>
            </div>
        </div>

        <div class="time-mode-btn">
            <button id="change-time-mode" class="dark-mode" @click="toggleTimeMode"></button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                inputSum: 1000,
                percentCommission: 0.045,
                isVisible: false,
                price: 0,
                firstCur: 'eur',
                secondCur: 'btc',
                firstSymbol: '€',
                secondSymbol: '₿',
            }
        },
        mounted() {
            this.firstCur = document.getElementById('currency').value;
            this.secondCur = document.getElementById('crypto').value;
            this.rateExchange(this.firstCur, this.secondCur);
        },

        computed: {
            commission() {
                return (this.inputSum <= 0 || this.inputSum === '') ? 0 : this.firstSymbol + ' ' + (this.inputSum * this.percentCommission).toFixed(2);
            },

            weSendSum() {
                return (this.inputSum <= 0 || this.inputSum === '') ? 0 : this.firstSymbol + ' ' + (this.inputSum - parseFloat(this.commission.substr(2))).toFixed(2);
            },

            getFinalSum() {
                return this.secondSymbol + ' ' + (parseFloat(this.weSendSum.substr(2)) * this.price).toFixed(2);
            }
        },

        methods: {
            calcCommission() {
                this.commission = this.inputSum * 0.045;
            },

            rateExchange(firstCur, secondCur) {
                let url = `https://api.cryptonator.com/api/full/${firstCur}-${secondCur}`;
                fetch(url)
                .then(response => response.json())
                .then(json => {
                    this.price = json.ticker.price;
                });
            },

            currencySymbol(currency) {
                let symbol;
                switch (currency) {
                    case 'eur': symbol = '€'; break;
                    case 'usd': symbol = '$'; break;
                    case 'gbp': symbol = '£'; break;
                    case 'btc': symbol = '₿'; break;
                    default: symbol = ''; break;
                }
                return symbol;
            },

            changeCurrency(event) {
                this.firstCur = event.target.value;
                this.firstSymbol = this.currencySymbol(this.firstCur);
                if (this.firstCur !== this.secondCur) {
                    this.rateExchange(this.firstCur, this.secondCur);
                } else this.price = 1;
            },

            changeCrypto(event) {
                this.secondCur = event.target.value;
                this.secondSymbol = this.currencySymbol(this.secondCur);
                if (this.secondCur !== this.firstCur) {
                    this.rateExchange(this.firstCur, this.secondCur);
                } else this.price = 1;
            },

            showForm(event) {
                const btn = document.querySelector('.press-me-btn');
                const btnText = btn.children[0];
                const form = document.querySelector('.exchange-block');
                btnText.classList.add('animate-hide-rotate');
                btn.classList.add('animate-width-reduce');
                btn.classList.remove('animate-fast-show');
                setTimeout(() => {
                    btn.style.width = '120px';
                    btn.style.borderRadius = '50%';
                    btnText.style.display = 'none';
                    btn.style.display = 'none';
                    form.classList.add('animate-scale-show');
                    form.style.display = 'block';
                    document.getElementById('exchange-form').style.opacity = 1;
                    document.getElementById('exchange-form').style.zIndex = 1;
                }, 800);
            },

            toggleVisible() {
                this.isVisible = !this.isVisible;
            },

            doInputSum(value) {
                this.inputSum = value.replace(/[^\d]/g, '');
            },

            toggleTimeMode() {
                const changeModeBtn = document.getElementById('change-time-mode');
                const wrapper = document.getElementById('wrapper');
                if (changeModeBtn.classList.contains('dark-mode')) {
                    changeModeBtn.classList.remove('dark-mode');
                    changeModeBtn.classList.add('light-mode');
                    wrapper.classList.remove('dark');
                    wrapper.classList.add('light');
                } else {
                    changeModeBtn.classList.remove('light-mode');
                    changeModeBtn.classList.add('dark-mode');
                    wrapper.classList.remove('light');
                    wrapper.classList.add('dark');
                }
            },

            sendMoney() {
                const animatePlane = document.querySelector('.animate-plane');
                const form = document.getElementById('exchange-form');
                const sendBtn = document.querySelector('.send');
                const goBack = document.querySelector('.go-back');
                form.classList.add('transparent', 'animate-scale-fade');

                animatePlane.style.display = 'block';
                animatePlane.classList.add('animate-compress');
                setTimeout(() => {
                    form.style.opacity = 0;
                    form.style.zIndex = -1;
                    animatePlane.classList.add('plane');
                    animatePlane.classList.add('animate-plane-fly');
                    setTimeout(() => {
                        animatePlane.style.display = 'none';
                        sendBtn.classList.add('animate-fade');
                        goBack.classList.add('animate-transform');
                        setTimeout(() => {
                            sendBtn.style.opacity = 0;
                            sendBtn.style.zIndex = -1;
                        }, 900);
                    }, 1300);
                }, 700);

                let finalSum = parseFloat(document.getElementById('you-get-sum').value.substr(2));
                let currentCurrency = document.getElementById('crypto').value;
                console.log(finalSum);
                console.log(currentCurrency);
            },

            goBack(event) {
                event.preventDefault();
                const pressMeBtn = document.querySelector('.press-me-btn');
                const exchangeBlock = document.querySelector('.exchange-block');
                const animatePlane = document.querySelector('.animate-plane');
                const form = document.getElementById('exchange-form');
                const sendBtn = document.querySelector('.send');
                const goBack = document.querySelector('.go-back');

                pressMeBtn.classList.remove('animate-width-reduce');
                exchangeBlock.classList.remove('animate-scale-show');
                exchangeBlock.classList.add('animate-fast-fade');
                animatePlane.classList.remove('animate-compress', 'plane', 'animate-plane-fly');
                form.classList.remove('transparent', 'animate-scale-fade');
                sendBtn.classList.remove('animate-fade');
                goBack.classList.remove('animate-transform');

                setTimeout(() => {
                    exchangeBlock.style.display = 'none';
                    exchangeBlock.classList.remove('animate-fast-fade');
                    pressMeBtn.classList.add('animate-fast-show');
                    pressMeBtn.style.display = 'block';
                    pressMeBtn.style.width = '430px';
                    pressMeBtn.style.borderRadius = '15px';
                    pressMeBtn.children[0].style.display = 'block';
                    pressMeBtn.children[0].classList.remove('animate-hide-rotate');
                    sendBtn.style.opacity = 1;
                    sendBtn.style.zIndex = 1;
                }, 300);
            }
        }
    }
</script>

<style lang="scss">
    #wrapper {
        position: relative;

        &.dark {
            background: #242432;

            .press-me-btn {
                background: #31313e;
                color: #f0f0ff;
                box-shadow: 0 24px 30px rgba(0, 0, 0, 0.15);
            }

            .animate-plane {
                background: #31313e;
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            }

            .plane {
                background: url('/img/plane_d.svg') no-repeat !important;
            }

            #exchange-form {
                background: #31313e;
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            }

            input, select, option {
                background: #3b3b49;
                color: #fba700;
            }

            .currency {
                &::before {
                    background: #fba700;
                }
                &::after {
                    background: #fba700;
                }
            }

            label {
                color: #f0f0ff;
            }

            .ctrl-btns {
                .send {
                    background: #fba700;
                    color: #fff;
                    box-shadow: 0 15px 15px rgba(9, 9, 25, 0.2);
                }
                .go-back {
                    color: #fba700;
                }
            }
        }

        &.light {
            background: #f0f0ff;

            .press-me-btn {
                background: #fff;
                color: #000;
                box-shadow: 0 24px 30px rgba(9, 9, 25, 0.05);
            }

            .animate-plane {
                background: #fff;
                box-shadow: 0 15px 30px rgba(9, 9, 25, 0.05);
            }

            .plane {
                background: url('/img/plane_l.svg') no-repeat !important;
            }

            #exchange-form {
                background: #fff;
                box-shadow: 0 15px 30px rgba(9, 9, 25, 0.05);
            }

            input, select, option {
                background: #f5f5ff;
                color: #2929cc;
            }

            .currency {
                &::before {
                    background: #2929cc;
                }
                &::after {
                    background: #2929cc;
                }
            }

            label {
                color: #000;
            }

            .ctrl-btns {
                .send {
                    background: #2929cc;
                    color: #fff;
                    box-shadow: 0 15px 15px rgba(9, 9, 25, 0.2);
                }
                .go-back {
                    color: #2929cc;
                }
            }
        }
    }

    .exchange-component {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .press-me-btn {
        height: 120px;
        width: 430px;
        font-size: 40px;
        font-weight: bold;
        border: none;
        border-radius: 15px;
        > span {
            width: 100%;
            height: 100%;
        }
        &:focus, &:active {
            outline: none;
            border: none;
        }
    }

    .animate-plane {
        width: 720px;
        height: 278px;
        position: absolute;
        left: 50%;
        margin-left: -360px;
        top: 50%;
        margin-top: -218px;
        border-radius: 15px;
        display: none;
    }
    .plane {
        width: 134px;
        height: 117px;
        margin-left: 0;
        margin-top: 0;
        top: 40%;
        left: 40%;
        box-shadow: none !important;
    }

    #exchange-form {
        width: 720px;
        height: 277px;
        border-radius: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 30;
        .top-exchange {
            display: flex;
            justify-content: space-between;
            > div {
                display: flex;
                flex-direction: column;
                margin: 12px 14px;
                &.withdrawal-sum, &.our-comission {
                    width: 224px;
                }
                &.currency-change {
                    width: 112px;
                }
            }
        }
        .bottom-exchange {
            display: flex;
            justify-content: space-between;
            > div {
                display: flex;
                flex-direction: column;
                margin: 12px 14px;
                &.we-send, &.you-get {
                    width: 224px;
                }
                &.currency-change {
                    width: 112px;
                }
            }
        }

        input, select, option {
            text-align: center;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 300;
            outline: none;
            border: none;
            &:focus, &:active {
                outline: none;
                border: none;
            }
        }

        input {
            height: 58px;
            width: 224px;
        }
        select, option {
            width: 112px;
            height: 58px;
        }
        select {
            appearance: none;
            padding: 0 25px;
            position: relative;
            z-index: 10;
        }
        .currency {
            position: relative;
            &::before {
                content: '';
                position: absolute;
                display: block;
                right: 28px;
                top: 28px;
                width: 12px;
                height: 2px;
                transform: rotate(44deg);
                z-index: 20;
            }
            &::after {
                content: '';
                position: absolute;
                display: block;
                right: 20px;
                width: 12px;
                top: 28px;
                height: 2px;
                transform: rotate(-44deg);
                z-index: 20;
            }
        }
        label {
            font-size: 16px;
            font-weight: 300;
        }
    }

    .ctrl-btns {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 30px;
        .send {
            width: 240px;
            position: relative;
            height: 60px;
            text-align: center;
            line-height: 60px;
            border-radius: 30px;
            font-size: 20px;
            font-weight: bold;
            transition: all .3s ease-out;
            &:hover {
                transform: translateY(6px);
                box-shadow: none !important;
            }
            &:active, &:focus {
                border: none;
                outline: none;
            }
        }
        .go-back {
            margin-top: 30px;
            font-size: 24px;
            font-weight: 300;
            color: #fba700;
            &:hover {
                text-decoration: none;
            }
        }
    }

    .time-mode-btn {
        position: absolute;
        bottom: 7%;
        left: 50%;
        margin-left: -50px;
        width: 100px;
        height: 52px;

        #change-time-mode {
            height: 100%;
            width: 100%;
            border: none;
            &:focus, &:active {
                border: none;
                outline: none;
            }
            &.dark-mode {
                background: url('/img/night.svg') no-repeat;
            }
            &.light-mode {
                background: url('/img/daynight.svg') no-repeat;
            }
        }
    }

    .animate-hide-rotate {
        animation: rotate-hide 0.8s linear;
    }
    .animate-show {
        animation: show 0.6s linear;
    }
    .animate-compress {
        animation: compress 0.7s linear;
    }
    .animate-scale-fade {
        animation: scale-fade 0.7s linear;
        z-index: -1;
    }
    .animate-plane-fly {
        animation: plane-fly 0.9s linear;
        animation-delay: 0.5s;
    }
    .animate-fade {
        animation: fade 0.6s linear;
        animation-delay: 0.4s;
    }
    .animate-transform {
        animation: go-up 0.5s linear;
        animation-delay: 0.5s;
        animation-fill-mode: forwards;
    }

    .transparent {
        background: transparent !important;
        box-shadow: none !important;
    }

    .animate-width-reduce {
        animation: width-reduce 0.9s linear;
    }

    .animate-scale-show {
        animation: scale-show 0.9s linear;
    }

    .animate-fast-fade {
        animation: fast-fade 0.3s linear;
    }

    .animate-fast-show {
        animation: fast-show 0.3s linear;
    }

    @keyframes scale-show {
        0% {
            transform: scale(0.1);
        }
        100% {
            transform: scale(1);
        }
    }

    @keyframes width-reduce {
        0% {
            width: 430px;
            border-radius: 15px
        }
        100% {
            width: 120px;
            border-radius: 50%;
        }
    }

    @keyframes rotate-hide {
        0% {
            transform: rotate(0) scale(1);
        }
        25% {
            transform: rotate(100deg) scale(.65);
        }
        50% {
            transform: rotate(200deg) scale(.40);
        }
        75% {
            transform: rotate(300deg) scale(.15);
        }
        100% {
            transform: rotate(400deg) scale(0);
        }
    }

    @keyframes show {
        0% {
            transform: scale(0);
        }
        50% {
            transform: scale(.5);
        }
        100% {
            transform: scale(1);
        }
    }

    @keyframes compress {
        0% {
            transform: rotate(0) scale(1) translate(0, 0);
        }
        30% {
            transform: rotate(-15deg) scale(0.7) translate(-20px, 20px);
        }
        60% {
            transform: rotate(-25deg) scale(0.5) translate(-30px, 35px);
        }
        100% {
            transform: rotate(-35deg) scale(0.2) translate(-50px, 60px);
        }
    }

    @keyframes scale-fade {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.1);
            opacity: 0.5;
        }
        100% {
            transform: scale(1.2);
            opacity: 0;
        }
    }

    @keyframes plane-fly {
        0% {
            transform: rotate(0) translate(0, 0);
            opacity: 1;
        }
        20% {
            transform: rotate(10deg) translate(20px, -15px);
            opacity: 1;
        }
        40% {
            transform: rotate(20deg) translate(50px, -60px);
            opacity: 1
        }
        60% {
            transform: rotate(30deg) translate(80px, -130px);
            opacity: 0.7
        }
        100% {
            transform: rotate(36deg) translate(140px, -220px);
            opacity: 0
        }
    }

    @keyframes fade {
        0% {
            opacity: 1;
        }
        100% {
            opacity: 0
        }
    }

    @keyframes go-up {
        0% {
            transform: translateY(0);
        }
        100% {
            transform: translateY(-200px);
        }
    }

    @keyframes fast-fade {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        100% {
            transform: scale(0);
            opacity: 0;
        }
    }
    @keyframes fast-show {
        0% {
            transform: scale(1.1);
            opacity: 0
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>