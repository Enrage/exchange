<template>
    <div class="exchange-component">
        <button class="press-me-btn" @click="showExchangeForm">Press me</button>

        <div class="exchange-block">
            <form action="/" id="exchange-form">
                <div class="top-exchange">
                    <div class="withdrawal-sum">
                        <label for="withdrawal">Сумма к выводу</label>
                        <input type="text" name="withdrawal" id="withdrawal">
                    </div>
                    <div class="currency-change">
                        <label for="currency">Валюта</label>
                        <select name="currency" id="currency">
                            <option value="eur">EUR</option>
                            <option value="usd">USD</option>
                            <option value="gbp">GBP</option>
                            <option value="btc">BTC</option>
                        </select>
                    </div>
                    <div class="our-comission">
                        <label for="comission">Наша комиссия</label>
                        <input type="text" name="comission" id="comission">
                    </div>
                </div>

                <div class="bottom-exchange">
                    <div class="we-send">
                        <label for="we-send-sum">Мы отправляем</label>
                        <input type="text" name="we-send-sum" id="we-send-sum">
                    </div>
                    <div class="currency-change">
                        <label for="crypto">Криптовалюта</label>
                        <select name="crypto" id="crypto">
                            <option value="btc">BTC</option>
                            <option value="eur">EUR</option>
                        </select>
                    </div>
                    <div class="you-get">
                        <label for="you-get-sum">Вы получаете</label>
                        <input type="text" name="you-get-sum" id="you-get-sum">
                    </div>
                </div>
            </form>
            <button>Press me</button>
            <a href="/">Go back</a>
        </div>

        <div class="time-mode-btn">
            <button id="change-time-mode" class="dark-mode" @click="toggleTimeMode"></button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {}
        },
        mounted() {
            console.log('Component exchange mounted.');
        },
        methods: {
            showExchangeForm() {
                console.log('form show');
            },

            toggleTimeMode() {
                const changeModeBtn = document.getElementById('change-time-mode');
                if (changeModeBtn.classList.contains('dark-mode')) {
                    changeModeBtn.classList.remove('dark-mode');
                    changeModeBtn.classList.add('light-mode');
                } else {
                    changeModeBtn.classList.remove('light-mode');
                    changeModeBtn.classList.add('dark-mode');
                }
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
        }
    }

    .press-me-btn {
        height: 120px;
        width: 430px;
        font-size: 40px;
        font-weight: bold;
        border: none;
        border-radius: 15px;
        position: absolute;
        top: 50%;
        margin-top: -60px;
        left: 50%;
        margin-left: -215px;
    }

    .exchange-block {
        display: none;
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
</style>