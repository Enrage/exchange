<template>
    <div class="exchange-component">
        <button class="press-me-btn" @click="showExchangeForm">Press me</button>

        <div class="exchange-block" v-show="isVisible">
            <form action="/" id="exchange-form">
                <div class="top-exchange">
                    <div class="withdrawal-sum">
                        <label for="withdrawal">Сумма к выводу</label>
                        <input type="text" name="withdrawal" id="withdrawal" placeholder="" v-model="inputSum">
                    </div>
                    <div class="currency-change">
                        <label for="currency">Валюта</label>
                        <div class="currency">
                            <select name="currency" id="currency">
                                <option value="eur">EUR</option>
                                <option value="usd">USD</option>
                                <option value="gbp">GBP</option>
                                <option value="btc">BTC</option>
                            </select>
                        </div>
                    </div>
                    <div class="our-comission">
                        <label for="comission">Наша комиссия</label>
                        <input type="text" name="comission" id="comission" placeholder="E45.00" disabled>
                    </div>
                </div>

                <div class="bottom-exchange">
                    <div class="we-send">
                        <label for="we-send-sum">Мы отправляем</label>
                        <input type="text" name="we-send-sum" id="we-send-sum" placeholder="E955.00">
                    </div>
                    <div class="currency-change">
                        <label for="crypto">Криптовалюта</label>
                        <div class="currency">
                            <select name="crypto" id="crypto">
                                <option value="btc">BTC</option>
                                <option value="eur">EUR</option>
                            </select>
                        </div>
                    </div>
                    <div class="you-get">
                        <label for="you-get-sum">Вы получаете</label>
                        <input type="text" name="you-get-sum" id="you-get-sum" placeholder="0,069 BTC">
                    </div>
                </div>
            </form>
            <div class="ctrl-btns">
                <button class="send">Press me</button>
                <a href="/" class="go-back">Go back</a>
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
                inputSum: 0,
                isVisible: false
            }
        },
        mounted() {
            console.log('Component exchange mounted.');
        },
        methods: {
            showExchangeForm(event) {
                event.target.style.display = 'none';
                this.toggleVisible();
            },

            toggleVisible() {
                this.isVisible = !this.isVisible;
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
        &:focus, &:active {
            outline: none;
            border: none;
        }
    }

    #exchange-form {
        width: 720px;
        height: 277px;
        background: #31313e;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        border-radius: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
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
            background: #3b3b49;
            color: #fba700;
            text-align: center;
            border-radius: 15px;
            font-size: 16px;
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
                background: #fba700;
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
                background: #fba700;
                transform: rotate(-44deg);
                z-index: 20;
            }
        }
        label {
            font-size: 16px;
            color: #f0f0ff;
        }
    }

    .ctrl-btns {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 30px;
        .send {
            width: 240px;
            height: 60px;
            text-align: center;
            line-height: 60px;
            background: #fba700;
            color: #fff;
            border-radius: 30px;
            font-size: 20px;
            font-weight: bold;
            box-shadow: 0 15px 15px rgba(0, 0, 0, 0.2);
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
</style>