<template>
    <div class="exchange-component">
        <button class="press-me-btn" @click="showExchangeForm">Press me</button>

        <div class="exchange-block" v-show="isVisible">
            <form action="/" id="exchange-form">
                <div class="top-exchange">
                    <div class="withdrawal-sum">
                        <label for="withdrawal">Сумма к выводу</label>
                        <input type="text" name="withdrawal" id="withdrawal" v-model="inputSum">
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
                inputSum: 1000,
                percentCommission: 0.045,
                isVisible: false,
                price: 0,
                firstCur: 'eur',
                secondCur: 'btc'
            }
        },
        mounted() {
            console.log('Component exchange mounted.');
            this.firstCur = document.getElementById('currency').value;
            this.secondCur = document.getElementById('crypto').value;
            this.rateExchange(this.firstCur, this.secondCur);
        },
        computed: {
            commission() {
                return (this.inputSum <= 0 || this.inputSum === '') ? 0 : (parseFloat(this.inputSum) * this.percentCommission).toFixed(2);
            },

            weSendSum() {
                return (this.inputSum <= 0 || this.inputSum === '') ? 0 : (parseFloat(this.inputSum) - parseFloat(this.commission)).toFixed(2);
            },

            getFinalSum() {
                return this.weSendSum * this.price;
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

            changeCurrency(event) {
                this.firstCur = event.target.value;
                this.rateExchange(this.firstCur, this.secondCur);
            },

            changeCrypto(event) {
                this.secondCur = event.target.value;
                this.rateExchange(this.firstCur, this.secondCur);
            },

            showExchangeForm(event) {
                event.target.style.display = 'none';
                this.toggleVisible();
            },

            toggleVisible() {
                this.isVisible = !this.isVisible;
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
        &:focus, &:active {
            outline: none;
            border: none;
        }
    }

    #exchange-form {
        width: 720px;
        height: 277px;
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
            border-radius: 30px;
            font-size: 20px;
            font-weight: bold;
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