angular.module('app.controllers', ['ui.utils.masks'])
//////////// PAGE 1
.controller('dataTertanggung13Ctrl', ['$scope', '$state', '$stateParams', 'dataFactory', 'spajProvider', '$ionicPopup', 'syncService', '$store',
	function ($scope, $state, $stateParams, dataFactory, spajProvider, $ionicPopup, syncService, $store) {
		$scope.data = null;
		$scope.pageId = 'aplikasiSPAJOnline.dataTertanggung13';
		$scope.genders = dataFactory.getGenders();
		$scope.agamas = dataFactory.getAgamas();
		$scope.spaj_guid = $stateParams.spaj_guid;
		// console.log($scope);
		
		$scope.imgDokumenKtp = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAACTCAMAAAAQusOOAAAABGdBTUEAALGPC/xhBQAAAwBQTFRFGyIlICUnLDQ7NjU2KTJALTJILjhGKTlLKT1SMTdDMjVLMDhGMztKOjtMNjxSKUBWKUNbNkBNOUFNOUlLOUVVKUZhKUhlKExrKE9wKlBvJ1N2J1V6J1h+KFFzKFV6KFh9OU1jOlJoN1h1Rj06RURORElXRVNcSlFdVUxYXFFWRk1oRFJjRVdqRlxgQ1hqTFRhSlJsTVlmSllqSldxU1pnVFpyTmlqRWJ4UmtsWmFtWW5uWGV0W3N0Y1RdaVxic11ie2Jca2ZrYGdxZGt1Ymt6am51anJ7emRoeHZ5J1mBN1+AL2CHN2OHP3CWRGmGQ26RTXKPQ3KWSHOUW22AUHKHU3OLWnCEWXKJV3uXYmqAaXaGaHyRcHaAdHuFc32IeH2HeH6Icn6QVYWfWIilboSNaoWdcoCOcImOfIKLd4mXaY6uZJGrZZy4eI6heJSscZm1ZaK+bK3KbrDNcK/NcrHOeLXSgV1Th2dckGVah2lnhG5wmXVum3h1onNnonpzsndmiYN6q4N6tYZ6wop6yJB73ZJ8g4aOgYeQg4mSiY+XjJGZloOEmIyRkpadgI6hh5eojp2wl5yjkZ+xiqKsiqK2nKOqlqi5qIqErpODtoyCvJSJupeQv6GRo6asp6uyrbG3uKeksrW6trm+i6vFhrTNhrnVkq7EnLLGpLXHqL7Sub3CjcHbmsjiqsPYvcHGvsLJt8nZvtHepczlqdHnu8/hutLmudrwxI6DyJaIyJqR0pqJz6ad2qGM2aWUza6lwrCtzLe127On5pyJ6KiO6KmU7LKc/6aM+qyV/LSb67ai/Luj8r+w/sKp/Mm1/tC+wMPGwcTJxcjMyMrOyMzRzNDV0NLW09XZ1tjc2drdwdPlxNfpxdrszdPhydjjydzuyN7x293hzOL13uDi2+3+3/D/7tfW9M3D/dXF8tjU6N7k/uXa4eLl5Obp5ujq7eDh6uPo6evt4+bx4uj04ez67O3w5PL+7vDy6vX+7/j9++zm/vHs8vP09vb49Pn8/vXy/v7+3kjLgwAAAAlwSFlzAAAOwQAADsEBuJFr7QAAABh0RVh0U29mdHdhcmUAcGFpbnQubmV0IDQuMS4zjST9ZwAAFx9JREFUeF7tnA14VfV9x1k9l5uFADE7CQqGCO0tFDdxkMpY5ksLA90yne1wLErVYR2s1laH25h0ndop0rpUhzi6gRXnRFsws6WNHbh1C+N6l1AQCKirJl401sQ2aiCVm3j2e/u/nLf7EjKep8/D93lyc87JOef/Ob/z/f/+L+fcjPF+AXUa+lTpNPSp0mnoU6X/D+jhoaHjrNzQ0LBsHE2NLnR/575Hb1o4f/78T82ZMWP2p2bPmP+HVy9Y9uiPDw/IDqOj0YLO9W6/b9knKxxnUo3jOFMrHScxFRYqa+GjtsY5c+Et6/b3DsnOJ6vRgM51broecEmTCBc+klNgrXISfNRWw8eUJKw13rv58GiAnzR03/Z1qXGIS6oBwMTUMmDGEHOc8QqmIjOuTZ93/75+OXTEOjno3P6GFLKCEviBcXaQ2amE9WqKM246B5mnwqazMOpXLjyQkxOMTCcD3bu2HhBYZRhG8vOkyoQImdEpzKx3mAKbGjb0yUlGohFD57Zcp3zsJBJJrHWTMIwCnEiUY+w5zvBjmCdPRLskqla0yJlK1wihc4/MgPJJjAgLk6p5kVU+tyLBfqY6SBeFzLVgnjJcqzm7fssIXTIi6AGDrCMLKLIkmjArUYnMug5iFkkysxg++ftPjQh7BNBDj85mXssLUbqA4n+5YqY6OIWYYVONVNL6fXLWUlQ69Pb5UBxL6GI0C6ATlK21N6aAn3WcOfR1TS/IiYtXqdC9a3X1K8CM0HF+1skQzVPRXGriLg06t6kKShMJWx7NKtN+JmaKMyzU0CZkrqMdUlvk/EWqJOg+k5eLYJ6VuKBcMfv8bOKMzJjhx80vKdilQG9SrR9KyOIF2WNWgpkpgTMz+FnVQSepK+mkZEnBLh46tw7OriVk8YI8XQFJz9RBZK4DZt2JkjjDpkm4aVPxXamioY+Y1IwStFhNuGBCwnWpJSdvUB3EoJo4k58xu9CNcJz616SogioW+oBLJ1YStBiVT5g1qzwBgcZEbbUpsOb3M3sDbgR1A1KHpbBCKhL6UT9zHHT5LNQFc1MTAHzuBITmOohGwDrImc/n51q8DOoZOqn9UlwBFQftszOUqDtyicT41EWgmanxtDYBVQ4L5R9HZuh9ELNqU2o0s27c6TKYGbLIJikwv4qCXsunVEpOlW7G+IvX7Epn2lGZdLr1ztWXzGR2JYksxRkW/H6eiH6mi8IrSOKejrNOisyrIqBzy+h0WlAiEZUvbiNeW5k9rWsuSmGoSTiQMXWQkgQzYxYxfkZmvDLUCik1nwpD5xbx2ZSwDAQqv5NjHFLm+bY1M0GrU1QR0bwTtTdwBFCGm+gysKFk5im4K2mtlJtHhaGvlZOJElgGMQtjtDKZTPuuCUByDuUNWGDzRvuZG0r4Qd0nBcerIHSwDuLpEXpmTJxtLS6XvAGH+NtBivNZxExr8EE7oMY+JEXHqhD0U3ImEdWg6hqA/oGA5dOuijIKIxwY8DPWQexgUwxMB5s1rlDmKwC935+fYWwHzLXojt0Clk+ZmbD7RGJW3igLtCnIjC05dfwk8TlupxQfo/zQnZHMaI9i3AH+SHAdNH42bQpsSuAVJCfDWs1Z8DFZQTup/J2+vNA5Pa4imRqUSCwWrPxqTbA3kDnQpqj8PFH7GXdQWiAE0coL7W9UTInQthQH3VaBIOxnnDmgOGNkqUOC50vqXh6mc6O8lTEf9AtyAhanJbqz0IqvESxMbtIoapktGeyBmzhfDoA6zsyMNZIbd5oOgQVWRT5b54Hut/v8fEJmLnMS5a1M1b5zzcxUyk7ZmdbFsEX+nLlImKk3HW5TyqhnSpvwCtDiSjOOC0aE8kD7MjSVQcxnQcwSKRXKu+6+u7X1eV4h7b4LNjyrYr+6/Gwyr/IznQHjTG3URFpT3qAdjB4QjAjFQ++Tg0mmxMnVzi/fMT6qOYzKJxvXPAyj90DeUHWQc52P2fL1uPjedSz023bmYD9jWsJ50dV7wj0lUFp+20q37VnNPSbys68OWp0oZKZmCzcpNcTOPsVC3y+Hoiw/A3NFm6/m7W5VBuatP7jbps+k/3M6HMOjQxVnYuaRFm2CNd5kMzvOI4ISUhx0r5mTEWYMCc3zN+6xoTMfS5Q/LIv48Y3yxEX2n9Nt0ED5vUFBLcOo+/3sizMotomJg7ZqoTkh+Bnc6O5JW7HcBZ3nv+JF2ro4kUhZTTxEehy7qxLdpf1cqfMzPTfQcfZxx41jYqCtQNMJqWuAeQNGLc4dNnTm4vLyjbxIW1snlF/ii/SXONdVB/ysmP1xpovScmNCHQN9rxwGpzcnRGa8s+e2+lzbqqolu6at1WJuT7eOL7scDqYw6jaF8zMmcJMM6Qpgzdb9ghNQNHSfnrIjP/PcmwrJxHMqLrGptaQm2spcOo7yhg4jM5OfcdPUy3ZdXHEl3Fa+qACz40YnkGho3emgMqgLhkGgFoEmjaTq+RUB3WafAZnxTjEgRPbir83v2Ps/3+z4x9RXr9ZFwIJRdAsTCd2nGnAuEcuYrG4jT3RdJlCW0sEuCOpOzs/MfKabuvI81512Rcp1p1/hup/o2PvDvXv3duzteH5vx6Jln//8smWfuWXlMiPXmREZ6kjoLQgMoh57YE6ImGuqIgAjlPlEHezOaaHSac761dcDyEpStE/XO84hWfQpElpmdJNYovGzubNwBfmHtUq7G2F3fdUPHh0mDWaPgY5m3ykCepEs+hQF3cX5juxFXYOzqA6qNo2qS1NRob5HuYvu1GNHveFDTz80NMjwPugeKdsngI5sYKKgN0EpoEosEZmnQA0ydZC7xxN3Clc+Pf8ROAbPQImtbv1Rb9/iS+r7B7ODqGMDCrqnJxbaeUqWbUVBmydBHGcsUTNjjz0xdaJjt9VxusPO8FOTDx71/iOdSb8/mKVIDwM0Y/d88NYJKdsnhF4my7YioPtgV5Yeuhk/07gfLT7xG0IWr7bx1hnAXQD9FnS2TgxKRXyvp+dNoO7oed/LeblhGJPCyCM3cDjXNeT19+dyBB3VKkZAb4ZdSexGwGU/49Ni6jFdjhaf4vr6p3sw8Jk9vMLKzOQ6qBs9sMfQ3va3vMHsUdZ77733s56ftoM1ct7BfTnvqQGAzg0MQMo4/JpAOxHPNSKg78FdQRFxpjqIcca+w6W2QTJ7/hvks8ydPPhjP+MZHj/qDR5842VvMCslgYaPvYvQ0SLoiKY8AlqeU1h3VjFPJghKJbBQ/VWhY+Hsna3WimqqsnAGmt8oq4VIP3Pr7bdlOeWJsoWg62XFUhi6F/dUzAho4kxZBOOM/R2oYnHzpqjW8aZVoqueghXx8VV/tuo7qiIOD3vDhSPthF+yCEPz2NDyM3xQDkBvYM9Uxv2AlPxaLPXG8dadggUcaT2YPZbt7u6GT1sK+viA5w28De7u6/WOcO1j6AO0bCsMzZ0lKMz067SfTZwJaWrl6mjqzF3j/H6m8eD6Yz83GjzKv1Wkc10Huvo7+/uP5Hq7DhxhUIYOmzoM/UnaE4RPSixm8AbPJeMa33rYof6HwmkrvZpeZrLqII2JHztGjQrrmKwUtse1smYUgs6pR8k85aOZqU2x/My33ql1/zrYt85s/EigFvO4uybYYWK9Uwg6PK8XhpapA81stWn+OOMmHEhN+zehZW2cCeZReYMzPPX5axy3YXlDQ8Onl8LH0iX4cX8HqhB0OH3EQXMdhIVq1aYkuU2BNQwjtuTQzMBaZe1d0JXmfJfJpNOyg7QpsGCNreCHz4CXPjk5vg2PyrCnhw9Rq2iraOgjZ+KOnClUnE0d1HHGNTUxANBKmXaANoM/nS3NEyGarlZ36vt0DEL3dx06kMv19+a6eqFJP9BFL8ExdLghD0Hr5xXGzzxzgJQUelWigzHDHQw0BC4daAfpOiOeruBjruSzdEjIHgOdnf0G2glNoIag1aiFSuQ4Yx+J4qyZCQnLp47fRoMM0P46qPwMdwrW6BizQ10rHRP29BD2nTT0QdpmKQT9AO/IQSVmKh+ZyZtQIvmZvAk7JOdc8xwCEzEos9RVzLiDYqYrKDsHvMF+hjPAYO77dFSBiug8KqtaMdB+PzMz1ki+9eRnTAu/07DtpexwjwJGdQy9umPbEldmHPEMxs90PtqEa7933kefpfQh0P25IYhv7xFYpDiXDq2YybzEjGumDuIT1nNv3gF59qjXI7ykDg+T746Vvwtn4PdRFDPNhBlvXNUN+72Lkunz/v6ug8dzna8NHM9Jd6NEaJCOkskbll1h4Ve3IV42O/y+8JJ6CDqbffLX+Rg+AzBbM2HorrrzeT/QMSk6pJKhdZxNm4LM8m40QDS9KmUOeh0CDOo4MSybX1mCx2DeYD/jveGrJuZkvew3itD0XsMkMi+ViGtUPm2CtSYpETR8wlC/5Zk+3ByJM85EcC8LuyB4wXjSBtlrNKAf4R3hzKaFoWcjVh2ETRYzUH/QQ9gdPScs5mx2pfYz3SnLG7DpatkJoIeHD7e0/Gj79pant29/+l+3Kz0lPYrQU+cQtHkYzjMHSKm84XCug/tswkT6uffBifffev8DGD3JFta/VCg/wwedAR9zcUO5XPYhfdYUAZEKqHDjoh8e8vN2KMO8REDMCFGDacMW9DNhIDLoRwZtdTWzbrul2fLdqz9Fw6t5zoDGdgmaVgha9fLKEJA6F8bPFGdYq3lcyiqsZ6Cpofqh48wThLXOStmD9GkVFrwo+G2r+F4eiv2smDnz0WTzFZhii9S283RLym0KeQPc4OtdN1hVBp1iqyRongkzZsMTop+razdIUUYbVq5cu+m557658k+0brzxxqYbmxpmbFiqzsAJVJ3UPsmrKVME7uDTfCEzCkF7DbKvUw2nMMw8KMDNtee9ImVpvfhbl/EjjV2/caFfvzbmpu4miTMiqTg7tc/IsaiXpxMzXRSExa/wxGkY2n5nSTObNgXc6KtCpB//E3c/Mmv80FUXXjjmM9nsLfqqxc+wNu1lORa1YzpswiLoCU9A9wiYURjaegEo0KbgGlxGRSjQ2TeQeOeX//LDvyK0ojMAGi+xuULaFD4DTmqm7HrxJGzCak6dsqDCL+CHoY/IviC8aj1Dk8QTYo9pjpRkhD2m9JfP+KUPfVRgLRF09olG8gaeAZmh2TKtOOgJKQLjXA0B9yn83mwYOmc9qwVvqErNvTz8uEVK0nodmf/8w3/xlZ2tDy8Kmpqhsy2u7Wfg8iWPm6TZQma0kq0q6adaCkN79guPVqWmvAFrtdK50/oJeiNDY1T8fZnQigQ6+925GEbzWOBJ3sxq0H6mInwKWzoKWndOWcbPzDw9mKStPh7qH4RWNGaR7PYqpCXlDSfZqPqIqO6r0M+cTrFInzYLlqUIaMvUIG5TkJmjPjHQ7SBDozK777700ru+csdvCq1IQ2e7b6BRCzHXzZONpB3QbJo37/2q6hUsSxHQw77XgGq0n/GEkLd8zW82+44KNA5td64+40MCq2Sgs9nH4P5L19HXPm2FTfilNCoC/m4r3LREQnv3yf5KZpCLbgw0h76xVnv77r8RWKUx9p3ZkOQ4lyW/K1tITYEibEW9iRAF/YL5UiRKtSlSg1qkJFafwGqlg/bw2enJaRiDskDXNmW9NYBzLJaqQl08UBR0zucPEo9ogTnRKAWJTKAzbX/7pbt3ZnYGct6YZbIn65V6zHxjfbmjhTqS3FkIxDnSHZHQ3kNyhBafkLLIXCmJ9VMhBmUy6d3/9aWP/fbfGz20YUPzA3ZzDer+AgTV3xFYT8lQqkxAUY8Ro6E7/f6A2gM/GITElISvvPcC6a4987/yF6WX5LelZneOvyNwlaqDoTg7FZGvqURCewvkGEt0QugQ+5LHm8IKyoDSezLvyl+UGoJjHNAOf6ZvwTjrOgi309L1AuRXNPRBOcYIT0hpyU4eOt0h85s/e+f1N34if9Ga1hhsQENqsvwc6E2Pjf6+TjS0F/geABgD/QwnrDQM29abRxeZTAiX1ei44SGDTy9WxDI71wlOQDHQ/ndjScw8VUO3NDULcXsmHcechbauZr0sR6vJ1EFqfS1VRL7tEQsd4WqMQWWtqz26cOu/M3I60/G6bAvLRaRAI+pTi6tH4aGRVtTDfFQcdESoMc6Oqyp+czN1STHMfbIpSi5Vsc/Fj4QbTMcvyFyFE6hRioOOSiAOhCQlvbOtfwQf1LKkdwUysU80+KutnPOirAfVTMNHGsxhNfcpolPKioU+RM9eQmrkmHVzKnuzoz295/58NQ0Hf2jXadFJZIMZ8mKc8b0YLTf2S/yx0MFuNatmLkN/XQ08ejJtzfkqGlREetGszv26bLG1lW8EtoO6g6MVmnfUioc+bl6wsZSiwl5cSL9Q73Rdky/Srrbr2M/a/X7SBmvmAOOMXT2thcIRoXho73CwMUedR6U1baVfpFca4msZQCMzvWwKmcd/dS/dYPyMzNU+5nFR3TtRHmj1ApZPBL3V7oBs/TtZiBSPwtWtX2KcvaPZZT/jSIvi7PPGuHhz5IfWj8ktzYbyuhvsPnWTv4Md0LnIDMcR86TqitnN21p2tGxb33Amtyk8aFYXZZT3iy75oL0u66vtIoTeajcWLcExo1/2zAFNY9aVVVS49JaiijP72c88I7J3p5QXOsIgCP1xO+k2W/aOkGuQ9FSVGcOaOuhnHhvZjdbKDx3Oe3Ogzt8gQKju+lBO8Olc/8vTdcBM30AzzDSixU2wIhobMW1gqwC07/sMKIDe5sOMa+pEjYhEzAiITjGPMrBN8b9TLir0hcRC0MHKGJ7Iyy9oXAwzeQPXzGSbnjnAHUQLwhNhfhWC9t72j3I5TxcvV5i5DmJkcS3sZ4u5vuC/xyoI7R3xU7vXND8RGC/lk6uRqLPMD/d8zPqiRPV5EwepMLTX6/8vCKDk+Uu/8M/PfK+7CPbpipkeOvGXtbQ3iJncXUqci4L2fyNKacK0JZ+7ddXj397xal50fOub/UxGwFznZ6YRAPaYWEXEuThorz+iaUS50/8AwG9//Fvx6FARmRko+fVr8oZiJvNYcV5QDHNx0F5f4Ev6li6fN2/5raBVgP6dMLlrXsxhdys/UwsTYB57b6G8wSoOOpyvlSqpyXCXLL8ZyUG3P7Pjexa7y34GZvPlQ366gt6gTXr2bmxx/76heGhvk++phi16SFBW5877Y+G+bRV4HeopQjciM/c+4IMyn/aGmaEhVeXr2PlUNLR3MMbY9ByW3zKodaeTVUi3rbr99m99m3p5xAw7RLQpZ+s6uKDYf0lSCrTXp99CDYnfmiGkSnfe8i8KNwiZ0c+mDlL/Oezna4uzM6kEaM/bHDWWAfEbVYjE3YmEe4XyOMfZ8jNQErPpb8DfnYqirYEqCdrrDU2XaTESOoWQJiWS5y+/+Yu3ykgLd/D52bQp+HP921JAcSoN2hvaEmoeWZXoDY4zLEgXaGzZNGYW81h1UN0WZJ5d5L+q0SoRGhqaFbFphO2qwmjawXCbwnHGOljpVKwrwc2skqE971CMR8TP1q3nl1yUn+mlAH5NR/u5Mrkibu4rj0YA7Xn7F8XUSHZwBDMlFtWmEPPZyOwuKvBPMaI1ImiI9sJIkyANewMAAyPagJ9hhzOXjQh5xNCe17ko2tuERH6OYKY4E3OZU7Uiz3RMfo0Y2vMOPxB+dAeBhp/YOoh/J+bK2ZtG4GWlk4CGAeT+yFRCfvbF2bQp5OfpzQdP6p8lnxQ06PiWRVF9En8dtP2crF90kv8/9uShQblDD9QHjYIeiGCet3RT5yj8Q+pRgEb1v7D5OrfK5xXu+CEzOsVtTN27+UCefzRSikYJGpXrP7x53QqdVICUmRub1q57pKv/ZD1haRShRbnca11dP2Lt6+rqPT76/6B89KFPgU5Dnyqdhj5VOg19qvQLCO15/wewijpumQ2JbQAAAABJRU5ErkJggg==";
		$scope.imgDokumenKtpChanged = false;
		$scope.tglLahirTertanggung = ''; 
		$scope.idagen = getQueryParam('idagen');
		$scope.token = getQueryParam('token');
		$scope.isOnline = false;
		
		$scope.isOnline = spajProvider.isInternetAvailable();

		new Date('10/10/1990');
		//INIT FORM 
		$scope.$on('$ionicView.enter', function () {
			$scope.init_data();
			if ($scope.spaj_guid == 'new') {
				newGuid = spajProvider.genSpajGUID();
				spajProvider.setSpajGUID(newGuid);
				$scope.data.spaj_guid = newGuid;
				$scope.data.build_id = spajProvider.getBuildId();
			}
			$scope.init_display();
		});
		$scope.init_display = function () {
			return true;
		};
		prospek = false;
		try {
			$pros = JSON.parse(spajProvider.getProspekData());
			prospek = $pros.find(obj => {
				return obj.build_id === spajProvider.getBuildId()
			});
		} catch (e) {
			prospek = {
				'jeniskelamin': '0',
				'nama': '',
				'tgllahir': ''
			}
		}
		$scope.init_data = function () {
			if (prospek) {
				$scope.data = {
					'spaj_guid': (spajProvider.getSpajGUID() == null || spajProvider.getSpajGUID() == '') ? spajProvider.genSpajGUID() : spajProvider.getSpajGUID(),
					'isPageTertanggung1Accepted': false,
					'agamaTertanggung': $scope.agamas[0].id,
					'jenkelTertanggung': prospek.kdjeniskelaminctt,
					'namaLengkapTertanggung': prospek.namactt,
					'nomorKTPTertanggung': prospek.noktpctt,
					'tglLahirTertanggung': prospek.tgllahirctt,
					'nomorNPWPTertanggung': '',
					'tglLahirPempol': '',
					'imageKTPTertanggung': null,
					'idagen': $scope.idagen,
					'namaAgen': prospek.namaAgen
				}
			} else {
				$scope.data = {
					'spaj_guid': (spajProvider.getSpajGUID() == null || spajProvider.getSpajGUID() == '') ? spajProvider.genSpajGUID() : spajProvider.getSpajGUID(),
					'isPageTertanggung1Accepted': false,
					'agamaTertanggung': $scope.agamas[0].id,
					'jenkelTertanggung': $scope.genders[0].id,
					'namaLengkapTertanggung': '',
					'nomorKTPTertanggung': '',
					'tglLahirTertanggung': $scope.tglLahirTertanggung,
					'nomorNPWPTertanggung': '',
					'tglLahirPempol': '',
					'imageKTPTertanggung': null,
					'idagen': $scope.idagen,
					'namaAgen': prospek.namaAgen
				}
			}
			
			$scope.imgDokumenKtpChanged = false;
			spajProvider.putImageTo('canvasKTP', $scope.imgDokumenKtp);
			if ($scope.spaj_guid == 'new') {
				//console.log(spajProvider.getSpajGUID())
				//$scope.init_data();
			} else if ($scope.spaj_guid == '' && spajProvider.getSpajGUID() != '') {
				spajProvider.setSpajGUID(spajProvider.getSpajGUID());
				$scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + $scope.pageId);
				try {
					decodedImage = spajProvider.ioBase64.decode(spajProvider.ioBase64.decode($scope.data.imageKTPTertanggung));
				} catch (e) {
					decodedImage = '';
				}
				spajProvider.putImageTo('canvasKTP', decodedImage);
				$scope.data.tglLahirTertanggung = new Date($scope.data.tglLahirTertanggung);
				$scope.imgDokumenKtp = decodedImage;
				$scope.imgDokumenKtpChanged = true;
			} else {
				spajProvider.setSpajGUID($scope.spaj_guid);
				$scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + $scope.pageId);
				let decodedImage = spajProvider.ioBase64.decode(spajProvider.ioBase64.decode($scope.data.imageKTPTertanggung));
				$scope.data.tglLahirTertanggung = new Date($scope.data.tglLahirTertanggung);
				if (spajProvider.putImageTo('canvasKTP', decodedImage)) {
					$scope.imgDokumenKtpChanged = true;
				}
				$scope.imgDokumenKtp = decodedImage;
				$scope.imgDokumenKtpChanged = true;
			}
			
			
		}
		$scope.validateThisFormOnPageAccept = function () {
			//validate datanya
			$scope.messages = [];
			try {
				if ($scope.data == null) {
					$scope.messages.push({
						"message": "Data ERROR. Null data."
					});
				}
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			//validate nama, NOMOR KTP NPWP
			try {
				tryMe = $scope.data.namaLengkapTertanggung;
				if ($scope.data.namaLengkapTertanggung == '') {
					$scope.messages.push({
						'message': "Nama Tertanggung harus benar!"
					});
				}
				tryMe = $scope.data.nomorKTPTertanggung;
				// console.log(tryMe.length)
				if ($scope.data.nomorKTPTertanggung == '' && !(tryMe.match(/^\d+$/)) && $scope.data.nomorKTPTertanggung.length != 16) {
					$scope.messages.push({
						'message': "Nomor KTP harus benar! (16 digit)"
					});
				}
				tryMe = $scope.data.nomorNPWPTertanggung;
				if ($scope.data.nomorNPWPTertanggung == '' && !(tryMe.match(/^\d+$/))) {
					//$scope.messages.push({'message':"Nomor NPWP harus benar!"}) ;
				}
				tryMe = $scope.data.tglLahirTertanggung;
				if ('' == tryMe) {
					$scope.messages.push({
						'message': "Masukkan tanggal lahir"
					});
				}
				tryMe = $scope.data.tempatLahirTertanggung;
				if (tryMe == null || tryMe == '') {
					$scope.messages.push({
						'message': "Tempat lahir masih kosong!"
					});
				}

				tryMe = $scope.data.jenkelTertanggung;
				if ('0' == tryMe) {
					$scope.messages.push({
						'message': "Silahkan Pilih Jenis kelamin"
					});
				}
				tryMe = $scope.data.agamaTertanggung;
				if ('0' == tryMe) {
					$scope.messages.push({
						'message': "Silahkan Pilih Agama"
					});
				}
				/*myRegex = /^[a-zA-Z\d ,.]*$/;
				if($scope.data.namaLengkapTertanggung != ''){
					nama = $scope.data.namaLengkapTertanggung;
					if(myRegex.test(nama) == false){
						$scope.messages.push({
							'message': "Format Nama Lengkap tidak sesuai! (harus diisi dengan abjad a-z)"
						});
					}
				}*/

				if (!$scope.imgDokumenKtpChanged) {
					$scope.messages.push({
						'message': "Silahkan foto KTP Tertanggung"
					});
				}
				myRegex = /^[a-zA-Z\s]*$/;
				if($scope.data.tempatLahirTertanggung != null){
					ttl = $scope.data.tempatLahirTertanggung;
					if(myRegex.test(ttl) == false){
						$scope.messages.push({
							'message': "Format Tempat lahir tidak sesuai! (harus diisi dengan abjad a-z)"
						});
					}
				}
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}

			if ($scope.messages.length > 0) {
				return $scope.messages;
			}
			return false;
		}
		$scope.changeImage = function () {
			spajProvider.takePict(this, 'canvasKTP');
			$scope.data.imageKTPTertanggung = spajProvider.getImageBase64('canvasKTP', 'jpg');
			$scope.imgDokumenKtpChanged = true;
			$scope.data.isPageTertanggung1Accepted = false;
		}
		$scope.saveDataSpaj = function () {
			$scope.data.imageKTPTertanggung = spajProvider.getImageBase64('canvasKTP', 'jpg');
			let $formdata = {
				'pageId': 'aplikasiSPAJOnline.dataTertanggung13',
				'data': $scope.data
			};
			spajProvider.setSpajGUID($scope.data.spaj_guid);
			$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + $formdata.pageId, $scope.data);
			spajProvider.setSpajElement($formdata);
			//$scope.showAlert('Test Display',angular.toJson(spajProvider.getSpajElement('aplikasiSPAJOnline.dataTertanggung13'), true));
		}
		$scope.moveToNextPage = function () {
			if ($scope.validateThisFormOnPageAccept()) {
				$scope.showAlert('Validasi', spajProvider.alertMessagebuilder($scope.messages));
				$scope.data.isPageTertanggung1Accepted = false;
				return false;
			} else {
				if ($scope.data.isPageTertanggung1Accepted) {
					if (confirm('Langsung menuju ke halaman form isian tempat tinggal tertanggung?')) {
						$state.go('aplikasiSPAJOnline.dataTertanggung23', {}, {
							reload: true,
							inherit: false
						});
					} else {
						return false;
					}
				}
			}
		}
		$scope.isPageAccepted = function () {
			if (!$scope.data.isPageTertanggung1Accepted) {
				$scope.showAlert('Apakah data sudah benar?', 'Pastikan Anda yakin data sudah benar untuk melanjutkan kehalaman berikutnya.');
				return false;
			}
		}
		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {});
		};
		$scope.$on('$ionicView.beforeEnter', function (event, viewData) {
			viewData.enableBack = true;
		});
		
	}
])
//////////// PAGE 1
//////////// PAGE 2
.controller('dataTertanggung23Ctrl', ['$scope', '$stateParams', 'dataFactory', 'spajProvider', '$ionicPopup', 'syncService', '$store', '$state',
	function ($scope, $stateParams, dataFactory, spajProvider, $ionicPopup, syncService, $store, $state) {
		$scope.pageId = 'aplikasiSPAJOnline.dataTertanggung23';
		$scope.messages = false;
		$scope.data = null;
		$scope.provinsis = dataFactory.getProvinsis();
		$scope.kabupatens = dataFactory.getKabupatens();
		$scope.kabupatens1 = dataFactory.getKabupatens();
		$scope.statustempattinggals = dataFactory.getStatusTempatTinggals();
		$scope.truefalse = false;
		//INIT FORM 
		prospek = false;
		try {
			$pros = JSON.parse(spajProvider.getProspekData());
			prospek = $pros.find(obj => {
				return obj.build_id === spajProvider.getBuildId()
			});
		} catch (e) {
			prospek = {
				'kdprovinsi': '0',
				'alamat': ''
			}
		}
		$scope.$on('$ionicView.enter', function () {
			$scope.init_data();
			//console.log(prospek);
			
			$scope.init_display();
		});
		$scope.init_display = function () {
			return true;
		};

		if(prospek.namacpp == prospek.namactt){
			$scope.truefalse = true;
		}

		$scope.init_data = function () {
			$scope.data = {
				'spaj_guid': spajProvider.getSpajGUID(),
				'build_id': spajProvider.getBuildId(),
				'provinsiKTPtertanggung': prospek.namacpp == prospek.namactt ? prospek.kdpropinsicpp : $scope.provinsis[0].id,
				'provinsiSurattertanggung': $scope.provinsis[0].id,
				'statusTinggalKTPtertanggung': $scope.statustempattinggals[0].id,
				'statusTinggalSurattertanggung': $scope.statustempattinggals[0].id,
				'alamatKTPtertanggung': prospek.namacpp == prospek.namactt ? prospek.alamatcpp : '',
				'alamatSurattertanggung': '',
				'kabupatenKTPtertanggung': prospek.namacpp == prospek.namactt ? prospek.kdkotamadyacpp : $scope.kabupatens[0].id,
				'kodeposKTPtertanggung': prospek.namacpp == prospek.namactt ? prospek.kdposcpp : '',
				'kodeposSurattertanggung': '',
				'isAlamatKTPtertanggungSama': false,
				'kabupatenSurattertanggung': '',
				'nomorHptertanggung': prospek.namacpp == prospek.namactt ? prospek.hpcpp : '',
				'nomorTelptertanggung': prospek.namacpp == prospek.namactt ? prospek.teleponcpp : '',
				'emailtertanggung': prospek.namacpp == prospek.namactt ? prospek.emailcpp : '',
				'truefalse' : $scope.truefalse,
				'isSetujuHPtertanggung': false,
				'isSetujuEmailtertanggung': false,
				'isPageTertanggung2Accepted': false
			}
			// get set data from localStorage
			if ($store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + $scope.pageId) == null) {
				//$scope.init_data();
			} else {
				$scope.setKabupatensValues(prospek.kdpropinsi);
				$scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + $scope.pageId);
				$scope.setKabupatensValues1($scope.data.provinsiSurattertanggung);
				$scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + $scope.pageId);
				
			}
		}
		$scope.validateThisFormOnPageAccept = function () {
			//validate datanya
			$scope.messages = [];
			try {
				if ($scope.data == null) {
					$scope.messages.push({
						"message": "Data ERROR. Null data."
					});
				}
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			//validate nama, NOMOR KTP NPWP
			try {

				console.log($scope.data.truefalse);
				console.log($scope.data.kabupatenKTPtertanggung);
				tryMe = $scope.data.statusTinggalKTPtertanggung;
				if ($scope.data.statusTinggalKTPtertanggung == '0') {
					$scope.messages.push({
						'message': "Silahkan pilih status tempat tinggal tertanggung!"
					});
				}
				tryMe = $scope.data.alamatKTPtertanggung;
				if ($scope.data.alamatKTPtertanggung == '' && !(tryMe.match(/^\d+$/))) {
					$scope.messages.push({
						'message': "Alamat KTP Harus benar!"
					});
				}
				tryMe = $scope.data.provinsiKTPtertanggung;
				if ($scope.data.provinsiKTPtertanggung == '0') {
					$scope.messages.push({
						'message': "Provinsi harus dipilih!"
					});
				}
				tryMe = $scope.data.kabupatenKTPtertanggung;
				console.log(tryMe)
				if ($scope.data.kabupatenKTPtertanggung == '0') {
					$scope.messages.push({
						'message': "Kabupaten harus benar!"
					});
				}
				tryMe = $scope.data.kodeposKTPtertanggung;
				if ($scope.data.kodeposKTPtertanggung == '' && !(tryMe.match(/^\d+$/))) {
					$scope.messages.push({
						'message':"Kodepos harus benar!"
					});
				}


			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			if (!$scope.data.isAlamatKTPtertanggungSama) {
				if ($scope.data.statusTinggalSurattertanggung == '0') $scope.messages.push({
					'message': "Status tempat tinggal alamat surat tertanggung harus dipilih!"
				});

				if ($scope.data.alamatSurattertanggung == '') $scope.messages.push({
					'message': "Alamat surat harus tertanggung benar!"
				});

				if ($scope.data.provinsiSurattertanggung == '0') $scope.messages.push({
					'message': "Provinsi alamat surat tertanggung harus benar!"
				});

				if ($scope.data.kabupatenSurattertanggung == '0') $scope.messages.push({
					'message': "Kabupaten alamat surat tertanggung harus benar!"
				});

				if($scope.data.kodeposSurattertanggung == 0)$scope.messages.push({
					'message': "Kode pos alamat surat tertanggung harus benar!"
				}) ;
			}

			tryMe = $scope.data.nomorHptertanggung;
			if ($scope.data.nomorHptertanggung == '' && !(tryMe.match(/^\d+$/))) {
				$scope.messages.push({
					'message': "Nomor HP harus benar!"
				});
			}
			// tryMe = $scope.data.nomorTelptertanggung;
			// if ($scope.data.nomorTelptertanggung == '' && !(tryMe.match(/^\d+$/))) {
			// 	$scope.messages.push({
			// 		'message': "Nomor Telepon harus benar!"
			// 	});
			// }
			tryMe = $scope.data.emailtertanggung;
			if ((typeof $scope.data.emailtertanggung == '') || !(tryMe.match(/\S+@\S+\.\S+/))) {
				$scope.messages.push({
					'message': "Email harus benar!"
				});
			}

			if ($scope.data.isSetujuHPtertanggung == false) {
				$scope.messages.push({
					'message': "Mohon untuk menggeser tombol Setuju untuk di telepon melalui Hp/Telepon"
				});
			}

			if ($scope.data.isSetujuEmailtertanggung == false) {
				$scope.messages.push({
					'message': "Mohon untuk menggeser tombol Setuju untuk di hubungi via email"
				});
			}

			if ($scope.messages.length > 0) {
				return $scope.messages;
			}
			return false;
		}
		$scope.setKabupatensValues1 = function (provs) {
			$scope.kabupatens1 = dataFactory.getKabupatens();
			kabs = $scope.kabupatens1.filter(obj => {
				return (obj.kdprop === '0' || obj.kdprop === provs)
			});
			$scope.kabupatens1 = kabs;
			$scope.data.kabupatenSurattertanggung = '0';
		}
		$scope.setKabupatensValues = function (provs) {
			$scope.kabupatens = dataFactory.getKabupatens();
			kabs = $scope.kabupatens.filter(obj => {
				return (obj.kdprop === '0' || obj.kdprop === provs)
			});
			$scope.kabupatens = kabs;
			$scope.data.kabupatenKTPtertanggung = '0';
		}
		$scope.alamatSamaDenganKTP = function () {
			let $alamaKTP = spajProvider.getSpajElement($scope.pageId);
			let $alamatSurat = this.data;
			if ($scope.data.isAlamatKTPtertanggungSama) {
				$alamatSurat.statusTinggalSurattertanggung = $alamaKTP.data.statusTinggalKTPtertanggung;
				$alamatSurat.alamatSurattertanggung = $alamaKTP.data.alamatKTPtertanggung;
				$alamatSurat.provinsiSurattertanggung = $alamaKTP.data.provinsiKTPtertanggung;
				$alamatSurat.kabupatenSurattertanggung = $alamaKTP.data.kabupatenKTPtertanggung;
				$alamatSurat.kodeposSurattertanggung = $alamaKTP.data.kodeposKTPtertanggung;
			} else {
				$alamatSurat.statusTinggalSurattertanggung = $scope.statustempattinggals[0].id;
				$alamatSurat.alamatSurattertanggung = "";
				$alamatSurat.provinsiSurattertanggung = $scope.provinsis[0].id;
				$alamatSurat.kabupatenSurattertanggung = "";
				$alamatSurat.kodeposSurattertanggung = "";
			}
		}
		$scope.isPageAccepted = function () {
			if (!$scope.data.isPageTertanggung2Accepted) {
				$scope.showAlert('Apakah data sudah benar?', 'Pastikan Anda yakin data sudah benar untuk melanjutkan kehalaman berikutnya.');
				return false;
			}
		}
		$scope.saveDataSpaj = function () {
			let $formdata = {
				'pageId': 'aplikasiSPAJOnline.dataTertanggung23',
				'data': $scope.data
			};
			spajProvider.setSpajGUID($scope.data.spaj_guid);
			$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + $formdata.pageId, $scope.data);
			spajProvider.setSpajElement($formdata);
			//$scope.showAlert('Test Display',angular.toJson(spajProvider.getSpajElement('aplikasiSPAJOnline.dataTertanggung23'), true));
		}
		$scope.moveToNextPage = function () {
			if ($scope.validateThisFormOnPageAccept()) {
				$scope.data.isPageTertanggung2Accepted = false;
				$scope.showAlert('Validasi', spajProvider.alertMessagebuilder($scope.messages));
				return false;
			} else {
				if ($scope.data.isPageTertanggung2Accepted) {
					if (confirm('Langsung menuju ke halaman form isian data pendukung tertanggung?')) {
						$state.go('aplikasiSPAJOnline.dataTertanggung33', {}, {
							reload: true,
							inherit: false
						});
					} else {
						return false;
					}
				}
			}
		}
		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {
				//console.log('Thank you for not eating my delicious ice cream cone');
			});
		};
	}
])
/////////// PAGE 2
/////////// PAGE 3
.controller('dataTertanggung33Ctrl', ['$scope', '$stateParams', 'dataFactory', 'spajProvider', '$ionicPopup', 'syncService', '$store', '$state',
	function ($scope, $stateParams, dataFactory, spajProvider, $ionicPopup, syncService, $store, $state) {
		$scope.pageId = 'aplikasiSPAJOnline.dataTertanggung33';
		$scope.messages = false;
		$scope.hubdgnpempols = dataFactory.getHubunganDenganPempols();
		$scope.provinsis = dataFactory.getProvinsis();
		$scope.genders = dataFactory.getGenders();
		$scope.statustempattinggals = dataFactory.getStatusTempatTinggals();
		$scope.pendidikans = dataFactory.getPendidikans();
		$scope.statuss = dataFactory.getStatusNikahs();
		$scope.kabupatens = dataFactory.getKabupatens();

		//INIT FORM 
		$scope.$on('$ionicView.enter', function () {
			$scope.init_data();
			$scope.init_display();
		});
		
		
		try{
			$scope.tglLahirTertanggungTambahan1 = new Date('10/10/1990');
			$scope.tglLahirTertanggungTambahan2 = new Date('10/10/1990');
			$scope.tglLahirTertanggungTambahan3 = new Date('10/10/1990');
			$scope.tglLahirTertanggungTambahan4 = new Date('10/10/1990');
		}catch(e){
			$scope.tglLahirTertanggungTambahan1 = '';
			$scope.tglLahirTertanggungTambahan2 = '';
			$scope.tglLahirTertanggungTambahan3 = '';
			$scope.tglLahirTertanggungTambahan4 = '';
		}

		$scope.hubunganKeluargas = dataFactory.getHubunganKeluargas(); 
		// $scope.jmlTertanggungs = dataFactory.getJmlTertanggungTambahan();

		$scope.jmlTertanggungs = [
			{'id': 0,'label': 'Tidak Ada'}
		   ,{'id': 1,'label': '1 Orang'}
	   ];
		
		$scope.setjmlTertanggung = function(xx){
			$scope.data.jmlTertanggungTambahan = xx;
			$scope.data.isAdaTertanggungTambahan1 = false;
			(xx>0)?$scope.data.isAdaTertanggungTambahan1=true:$scope.data.isAdaTertanggungTambahan=false;
		}

		$scope.setKabupatensValues = function (provs) {
			$scope.kabupatens = dataFactory.getKabupatens();
			kabs = $scope.kabupatens.filter(obj => {
				return (obj.kdprop === '0' || obj.kdprop === provs)
			});
			$scope.kabupatens = kabs;
			$scope.data.kabupatenSuratSaudaraTertanggung = '0';
		}

		$scope.init_display = function () {
			return true;
		};
		
		prospek = false;
		try {
			$pros = JSON.parse(spajProvider.getProspekData());
			prospek = $pros.find(obj => {
				return obj.build_id === spajProvider.getBuildId()
			});
		} catch (e) {}

		console.log(prospek)
		
		if(!(prospek.IS_PAYOR_DEATH || prospek.IS_PAYOR_TPD || prospek.IS_SPOUSE_DEATH || prospek.IS_SPOUSE_TPD || prospek.ispci || prospek.issci)){
			num = 0;
			adaTT1 = false;
		}else{
			num = 1;
			adaTT1 = true;
		}

		//UAT 10 January 2023
		if (prospek.kd_produk.match(/APP/i)) {
			$scope.labelusiaProduktifTertanggung = true;
		} else {
			$scope.labelusiaProduktifTertanggung = false;
		}
		
		$scope.init_data = function () {

			if ($store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + $scope.pageId) == null) {
				$scope.data = {
					'spaj_guid': spajProvider.getSpajGUID(),
					
					'hubdgnPempol': prospek.kdhubunganctt,
					'usiaProduktifTertanggung': prospek.usiaproduktif,
					'statusPernikahanTertanggung': $scope.statuss[0].id,
					'pendidikanTertanggung': $scope.pendidikans[0].id,
					'jmlTertanggungTambahan': $scope.jmlTertanggungs[num].id,
					'tinggiBadanTertanggung': '',
					'beratBadanTertanggung': '',
					'ibuKandungTertanggung': '',
					
					'namaSaudaraTertanggung': '',
					'alamatSuratSaudaraTertanggung': '',
					'provinsiSuratSaudaraTertanggung': $scope.provinsis[0].id,
					'kabupatenSuratSaudaraTertanggung': '',
					'kodeposSuratSaudaraTertanggung': '',
					'noTelpSaudaraTertanggung': '',
					'noHpSaudaraTertanggung': '',
					
					'isAdaTertanggungTambahan1': adaTT1,
					
					'hubunganTT1DenganTTU': $scope.hubunganKeluargas[0].id,
					'jenisKelaminTertanggungTambahan1': $scope.genders[0].id,
					'namaTertanggungTambahan1': '',
					'noKtpTertanggungTambahan1': '',
					'tglLahirTertanggungTambahan1': $scope.tglLahirTertanggungTambahan1,
					'tempatLahirTertanggungTambahan1': '',
					'tinggiBadanTertanggungTambahan1': '',
					'beratBadanTertanggungTambahan1': '',
					'isTertanggungTambahan1Bekerja':false,
					'namaKantorTertanggungTambahan1': '',
					'alamatKantorTertanggungTambahan1': '',

					'hubunganTT2DenganTTU': $scope.hubunganKeluargas[0].id,
					'jenisKelaminTertanggungTambahan2': $scope.genders[0].id,
					'namaTertanggungTambahan2': '',
					'noKtpTertanggungTambahan2': '',
					'tglLahirTertanggungTambahan2': $scope.tglLahirTertanggungTambahan2,
					'tempatLahirTertanggungTambahan2': '',
					'tinggiBadanTertanggungTambahan2': '',
					'beratBadanTertanggungTambahan2': '',
					'isTertanggungTambahan2Bekerja':false,
					'namaKantorTertanggungTambahan2': '',
					'alamatKantorTertanggungTambahan2': '',
					
					'hubunganTT3DenganTTU': $scope.hubunganKeluargas[0].id,
					'jenisKelaminTertanggungTambahan3': $scope.genders[0].id,
					'namaTertanggungTambahan3': '',
					'noKtpTertanggungTambahan3': '',
					'tglLahirTertanggungTambahan3': $scope.tglLahirTertanggungTambahan3,
					'tempatLahirTertanggungTambahan3': '',
					'tinggiBadanTertanggungTambahan3': '',
					'beratBadanTertanggungTambahan3': '',
					'isTertanggungTambahan3Bekerja':false,
					'namaKantorTertanggungTambahan3': '',
					'alamatKantorTertanggungTambahan3': '',

					'hubunganTT4DenganTTU': $scope.hubunganKeluargas[0].id,
					'jenisKelaminTertanggungTambahan4': $scope.genders[0].id,
					'namaTertanggungTambahan4': '',
					'noKtpTertanggungTambahan4': '',
					'tglLahirTertanggungTambahan4': $scope.tglLahirTertanggungTambahan4,
					'tempatLahirTertanggungTambahan4': '',
					'tinggiBadanTertanggungTambahan4': '',
					'beratBadanTertanggungTambahan4': '',
					'isTertanggungTambahan4Bekerja':false,
					'namaKantorTertanggungTambahan4': '',
					'alamatKantorTertanggungTambahan4': '',

					'isPageTertanggung3Accepted': false,
				}
			} else {
				$scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + $scope.pageId);
				//console.log($scope.data);
				try{
					$scope.data.tglLahirTertanggungTambahan1 = new Date($scope.data.tglLahirTertanggungTambahan1);
					$scope.data.tglLahirTertanggungTambahan2 = new Date($scope.data.tglLahirTertanggungTambahan2);
					$scope.data.tglLahirTertanggungTambahan3 = new Date($scope.data.tglLahirTertanggungTambahan3);
					$scope.data.tglLahirTertanggungTambahan4 = new Date($scope.data.tglLahirTertanggungTambahan4);

				}catch(e){
					//console.log(e);
				}
				
			}
		}

		$scope.setTT = function(status){
			$scope.data.isAdaTertanggungTambahan1 = status;
			if(status == false) {
				$scope.data.jmlTertanggungTambahan = '0';
			}else{
				
			}
		}
		
		$scope.saveDataSpaj = function () {
			let $formdata = {
				'pageId': $scope.pageId,
				'data': $scope.data
			};
			
			try{ 
				$scope.data.tglLahirTertanggungTambahan1 = new Date($scope.data.tglLahirTertanggungTambahan1);
				$scope.data.tglLahirTertanggungTambahan2 = new Date($scope.data.tglLahirTertanggungTambahan2);
				$scope.data.tglLahirTertanggungTambahan3 = new Date($scope.data.tglLahirTertanggungTambahan3);
				$scope.data.tglLahirTertanggungTambahan4 = new Date($scope.data.tglLahirTertanggungTambahan4);
			}catch (e){
				console.log(e);
			}

			
			spajProvider.setSpajGUID($scope.data.spaj_guid);
			$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + $formdata.pageId, $scope.data);
			spajProvider.setSpajElement($formdata);
			//$scope.showAlert('Test Display',angular.toJson(spajProvider.getSpajElement('aplikasiSPAJOnline.dataTertanggung23'), true));
			//console.log($scope.data);
		}
		
		$scope.moveToNextPage = function () {
			if ($scope.validateThisFormOnPageAccept()) {
				$scope.showAlert('Validasi', spajProvider.alertMessagebuilder($scope.messages));
				$scope.data.isPageTertanggung3Accepted = false;
				return false;
			} else {
				if ($scope.data.isPageTertanggung3Accepted) {
					if (confirm('Langsung menuju ke halaman form isian pekerjaan tertanggung?')) {
						$state.go('aplikasiSPAJOnline.pekerjaanTertanggung', {}, {
							reload: true,
							inherit: false
						});
					} else {
						return false;
					}
				}
			}
		}
		
		if ($store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + $scope.pageId) == null) {
			$scope.init_data();
		} else {
			$scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + $scope.pageId);
		}
		$scope.isPageAccepted = function () {
			if (!$scope.data.isPageTertanggung3Accepted) {
				$scope.showAlert('Apakah data sudah benar?', 'Pastikan Anda yakin data sudah benar untuk melanjutkan kehalaman berikutnya.');
				return false;
			}
		}
		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {
				//console.log('Thank you for not eating my delicious ice cream cone');
			});
		};
		$scope.validateThisFormOnPageAccept = function () {
			//validate datanya
			$scope.messages = [];
			try {
				if ($scope.data == null) {
					$scope.messages.push({
						"message": "Data ERROR. Null data."
					});
				}
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			//validate nama, NOMOR KTP NPWP
			try {

				//console.log($scope.data.jmlTertanggungTambahan);

				if($scope.data.usiaProduktifTertanggung == '0'){
					$scope.messages.push({
						'message': "Usia Tertanggung harus benar !"
					});
				}

				if ($scope.data.tinggiBadanTertanggung == '') {
					$scope.messages.push({
						'message': "Tinggi badan harus benar! (50cm - 250cm)"
					});
				}

				if ($scope.data.beratBadanTertanggung == '') {
					$scope.messages.push({
						'message': "Berat badan harus benar! (10kg - 300kg)"
					});
				}
				tryMe = $scope.data.ibuKandungTertanggung;
				if ($scope.data.ibuKandungTertanggung == '' && !(tryMe.match(/^[A-Za-z]+$/))) {
					$scope.messages.push({
						'message': "Nama ibu kandung harus benar! (tidak boleh kosong)"
					});
				}
				tryMe = $scope.data.pendidikanTertanggung;
				if ('0' == tryMe) {
					$scope.messages.push({
						'message': "Silahkan pilih Pendidikan Terakhir"
					});
				}
				tryMe = $scope.data.statusPernikahanTertanggung;
				if ('0' == tryMe) {
					$scope.messages.push({
						'message': "Silahkan pilih Status Pernikahan"
					});
				}

				if(prospek.IS_PAYOR_DEATH || prospek.IS_PAYOR_TPD || prospek.IS_SPOUSE_DEATH || prospek.IS_SPOUSE_TPD || prospek.ispci || prospek.issci){
					if($scope.data.jmlTertanggungTambahan == 0){
						$scope.messages.push({
							'message': "Anda telah memilih Rider Payor / Spouse Payor, silahkan tambahkan tertanggung tambahan!"
						});
					}
				}

				if($scope.data.jmlTertanggungTambahan == 1){

					/** Tertanggung Tambahan 1 */
					if ($scope.data.hubunganTT1DenganTTU == '0') $scope.messages.push({
						'message': "Silahkan pilih hubungan tertanggung tambahan 1 dengan tertanggung utama"
					});

					if ($scope.data.jenisKelaminTertanggungTambahan1 == '0') $scope.messages.push({
						'message': "Jenis Kelamin tertanggung tambahan 1 harus benar!"
					});
					
					if ($scope.data.namaTertanggungTambahan1 == '') $scope.messages.push({
						'message': "Nama tertanggung tambahan harus 1 benar! (tidak boleh kosong)"
					});

					if ($scope.data.noKtpTertanggungTambahan1 == '') $scope.messages.push({
						'message': "Nomor KTP tertanggung tambahan 1 harus benar!"
					});

					if($scope.data.noKtpTertanggungTambahan1 != ''){
						if($scope.data.noKtpTertanggungTambahan1.length != 16){
							$scope.messages.push({
								'message': "Nomor KTP tertanggung tambahan 1 tidak sesuai! (16 digit)"
							});
						}
					}

					if ($scope.data.tglLahirTertanggungTambahan1 == '') $scope.messages.push({
						'message': "Tanggal lahir tertanggung tambahan 1 harus benar!"
					});
					
					if ($scope.data.tempatLahirTertanggungTambahan1 == '') $scope.messages.push({
						'message': "Tempat lahir tertanggung tambahan 1 harus benar! (tidak boleh kosong)"
					});
					if ($scope.data.tinggiBadanTertanggungTambahan1 == 0) $scope.messages.push({
						'message': "Tinggi tertanggung tambahan 1 harus benar! (50cm - 250cm)"
					});
					if ($scope.data.beratBadanTertanggungTambahan1 == 0) $scope.messages.push({
						'message': "Berat Badan tertanggung tambahan 1 harus benar! (10kg - 300kg)"
					});

					if($scope.data.isTertanggungTambahan1Bekerja){
						if($scope.data.namaKantorTertanggungTambahan1 == ''){
							$scope.messages.push({
								'message': "Nama Kantor tertanggung tambahan 1 harus benar!"
							});
						}

						if($scope.data.alamatKantorTertanggungTambahan1 == ''){
							$scope.messages.push({
								'message': "Alamat Kantor tertanggung tambahan 1 harus benar!"
							});
						}
					}
				}

				if($scope.data.jmlTertanggungTambahan == 2) {
					/** Tertanggung Tambahan 1 */
					if ($scope.data.hubunganTT1DenganTTU == '0') $scope.messages.push({
						'message': "Silahkan pilih hubungan tertanggung tambahan 1 dengan tertanggung utama"
					});

					if ($scope.data.jenisKelaminTertanggungTambahan1 == '0') $scope.messages.push({
						'message': "Jenis Kelamin tertanggung tambahan 1 harus benar!"
					});
					
					if ($scope.data.namaTertanggungTambahan1 == '') $scope.messages.push({
						'message': "Nama tertanggung tambahan harus 1 benar! (tidak boleh kosong)"
					});

					if ($scope.data.noKtpTertanggungTambahan1 == '') $scope.messages.push({
						'message': "Nomor KTP tertanggung tambahan 1 harus benar!"
					});

					if($scope.data.noKtpTertanggungTambahan1 != ''){
						if($scope.data.noKtpTertanggungTambahan1.length != 16){
							$scope.messages.push({
								'message': "Nomor KTP tertanggung tambahan 1 tidak sesuai! (16 digit)"
							});
						}
					}

					if ($scope.data.tglLahirTertanggungTambahan1 == '') $scope.messages.push({
						'message': "Tanggal lahir tertanggung tambahan 1 harus benar!"
					});
					
					if ($scope.data.tempatLahirTertanggungTambahan1 == '') $scope.messages.push({
						'message': "Tempat lahir tertanggung tambahan 1 harus benar! (tidak boleh kosong)"
					});
					if ($scope.data.tinggiBadanTertanggungTambahan1 == 0) $scope.messages.push({
						'message': "Tinggi tertanggung tambahan 1 harus benar! (50cm - 250cm)"
					});
					if ($scope.data.beratBadanTertanggungTambahan1 == 0) $scope.messages.push({
						'message': "Berat Badan tertanggung tambahan 1 harus benar! (10kg - 300kg)"
					});

					if($scope.data.isTertanggungTambahan1Bekerja){
						if($scope.data.namaKantorTertanggungTambahan1 == ''){
							$scope.messages.push({
								'message': "Nama Kantor tertanggung tambahan 1 harus benar!"
							});
						}

						if($scope.data.alamatKantorTertanggungTambahan1 == ''){
							$scope.messages.push({
								'message': "Alamat Kantor tertanggung tambahan 1 harus benar!"
							});
						}
					}

					/** Tertanggung Tambahan 2 */
					if ($scope.data.hubunganTT2DenganTTU == '0') $scope.messages.push({
						'message': "Silahkan pilih hubungan tertanggung tambahan 2 dengan tertanggung utama"
					});

					if ($scope.data.jenisKelaminTertanggungTambahan2 == '0') $scope.messages.push({
						'message': "Jenis Kelamin tertanggung tambahan 2 harus benar!"
					});
					
					if ($scope.data.namaTertanggungTambahan2 == '') $scope.messages.push({
						'message': "Nama tertanggung tambahan harus 2 benar! (tidak boleh kosong)"
					});

					if ($scope.data.noKtpTertanggungTambahan2 == '') $scope.messages.push({
						'message': "Nomor KTP tertanggung tambahan 2 harus benar!"
					});

					if($scope.data.noKtpTertanggungTambahan2 != ''){
						if($scope.data.noKtpTertanggungTambahan2.length != 16){
							$scope.messages.push({
								'message': "Nomor KTP tertanggung tambahan 2 tidak sesuai! (16 digit)"
							});
						}
					}

					if ($scope.data.tglLahirTertanggungTambahan2 == '') $scope.messages.push({
						'message': "Tanggal lahir tertanggung tambahan 2 harus benar!"
					});
					
					if ($scope.data.tempatLahirTertanggungTambahan2 == '') $scope.messages.push({
						'message': "Tempat lahir tertanggung tambahan 2 harus benar! (tidak boleh kosong)"
					});
					if ($scope.data.tinggiBadanTertanggungTambahan2 == 0) $scope.messages.push({
						'message': "Tinggi tertanggung tambahan 2 harus benar! (50cm - 250cm)"
					});
					if ($scope.data.beratBadanTertanggungTambahan2 == 0) $scope.messages.push({
						'message': "Berat Badan tertanggung tambahan 2 harus benar! (10kg - 300kg)"
					});

					if($scope.data.isTertanggungTambahan2Bekerja){
						if($scope.data.namaKantorTertanggungTambahan2 == ''){
							$scope.messages.push({
								'message': "Nama Kantor tertanggung tambahan 2 harus benar!"
							});
						}

						if($scope.data.alamatKantorTertanggungTambahan2 == ''){
							$scope.messages.push({
								'message': "Alamat Kantor tertanggung tambahan 2 harus benar!"
							});
						}
					}

				}
				
				
				if($scope.data.jmlTertanggungTambahan == 3){
					/** Tertanggung Tmabahan 1 */
					if ($scope.data.hubunganTT1DenganTTU == '0') $scope.messages.push({
						'message': "Silahkan pilih hubungan tertanggung tambahan 1 dengan tertanggung utama"
					});

					if ($scope.data.jenisKelaminTertanggungTambahan1 == '0') $scope.messages.push({
						'message': "Jenis Kelamin tertanggung tambahan 1 harus benar!"
					});
					
					if ($scope.data.namaTertanggungTambahan1 == '') $scope.messages.push({
						'message': "Nama tertanggung tambahan harus 1 benar! (tidak boleh kosong)"
					});

					if ($scope.data.noKtpTertanggungTambahan1 == '') $scope.messages.push({
						'message': "Nomor KTP tertanggung tambahan 1 harus benar!"
					});

					if($scope.data.noKtpTertanggungTambahan1 != ''){
						if($scope.data.noKtpTertanggungTambahan1.length != 16){
							$scope.messages.push({
								'message': "Nomor KTP tertanggung tambahan 1 tidak sesuai! (16 digit)"
							});
						}
					}

					if ($scope.data.tglLahirTertanggungTambahan1 == '') $scope.messages.push({
						'message': "Tanggal lahir tertanggung tambahan 1 harus benar!"
					});
					
					if ($scope.data.tempatLahirTertanggungTambahan1 == '') $scope.messages.push({
						'message': "Tempat lahir tertanggung tambahan 1 harus benar! (tidak boleh kosong)"
					});
					if ($scope.data.tinggiBadanTertanggungTambahan1 == 0) $scope.messages.push({
						'message': "Tinggi tertanggung tambahan 1 harus benar! (50cm - 250cm)"
					});
					if ($scope.data.beratBadanTertanggungTambahan1 == 0) $scope.messages.push({
						'message': "Berat Badan tertanggung tambahan 1 harus benar! (10kg - 300kg)"
					});

					if($scope.data.isTertanggungTambahan1Bekerja){
						if($scope.data.namaKantorTertanggungTambahan1 == ''){
							$scope.messages.push({
								'message': "Nama Kantor tertanggung tambahan 1 harus benar!"
							});
						}

						if($scope.data.alamatKantorTertanggungTambahan1 == ''){
							$scope.messages.push({
								'message': "Alamat Kantor tertanggung tambahan 1 harus benar!"
							});
						}
					}

					/** Tertanggung Tambahan 2 */
					if ($scope.data.hubunganTT2DenganTTU == '0') $scope.messages.push({
						'message': "Silahkan pilih hubungan tertanggung tambahan 2 dengan tertanggung utama"
					});

					if ($scope.data.jenisKelaminTertanggungTambahan2 == '0') $scope.messages.push({
						'message': "Jenis Kelamin tertanggung tambahan 2 harus benar!"
					});
					
					if ($scope.data.namaTertanggungTambahan2 == '') $scope.messages.push({
						'message': "Nama tertanggung tambahan harus 2 benar! (tidak boleh kosong)"
					});

					if ($scope.data.noKtpTertanggungTambahan2 == '') $scope.messages.push({
						'message': "Nomor KTP tertanggung tambahan 2 harus benar!"
					});

					if($scope.data.noKtpTertanggungTambahan2 != ''){
						if($scope.data.noKtpTertanggungTambahan2.length != 16){
							$scope.messages.push({
								'message': "Nomor KTP tertanggung tambahan 2 tidak sesuai! (16 digit)"
							});
						}
					}

					if ($scope.data.tglLahirTertanggungTambahan2 == '') $scope.messages.push({
						'message': "Tanggal lahir tertanggung tambahan 2 harus benar!"
					});
					
					if ($scope.data.tempatLahirTertanggungTambahan2 == '') $scope.messages.push({
						'message': "Tempat lahir tertanggung tambahan 2 harus benar! (tidak boleh kosong)"
					});
					
					if ($scope.data.tinggiBadanTertanggungTambahan2 == 0) $scope.messages.push({
						'message': "Tinggi tertanggung tambahan 2 harus benar! (50cm - 250cm)"
					});
					if ($scope.data.beratBadanTertanggungTambahan2 == 0) $scope.messages.push({
						'message': "Berat Badan tertanggung tambahan 2 harus benar! (10kg - 300kg)"
					});

					if($scope.data.isTertanggungTambahan2Bekerja){
						if($scope.data.namaKantorTertanggungTambahan2 == ''){
							$scope.messages.push({
								'message': "Nama Kantor tertanggung tambahan 2 harus benar!"
							});
						}

						if($scope.data.alamatKantorTertanggungTambahan2 == ''){
							$scope.messages.push({
								'message': "Alamat Kantor tertanggung tambahan 2 harus benar!"
							});
						}
					}

					/** Tertanggung Tambahan 3 */
					if ($scope.data.hubunganTT3DenganTTU == '0') $scope.messages.push({
						'message': "Silahkan pilih hubungan tertanggung tambahan 3 dengan tertanggung utama"
					});

					if ($scope.data.jenisKelaminTertanggungTambahan3 == '0') $scope.messages.push({
						'message': "Jenis Kelamin tertanggung tambahan 3 harus benar!"
					});
					
					if ($scope.data.namaTertanggungTambahan3 == '') $scope.messages.push({
						'message': "Nama tertanggung tambahan harus 3 benar! (tidak boleh kosong)"
					});

					if ($scope.data.noKtpTertanggungTambahan3 == '') $scope.messages.push({
						'message': "Nomor KTP tertanggung tambahan 3 harus benar!"
					});

					if($scope.data.noKtpTertanggungTambahan3 != ''){
						if($scope.data.noKtpTertanggungTambahan3.length != 16){
							$scope.messages.push({
								'message': "Nomor KTP tertanggung tambahan 3 tidak sesuai! (16 digit)"
							});
						}
					}

					if ($scope.data.tglLahirTertanggungTambahan3 == '') $scope.messages.push({
						'message': "Tanggal lahir tertanggung tambahan 3 harus benar!"
					});
					
					if ($scope.data.tempatLahirTertanggungTambahan3 == '') $scope.messages.push({
						'message': "Tempat lahir tertanggung tambahan 3 harus benar! (tidak boleh kosong)"
					});
					if ($scope.data.tinggiBadanTertanggungTambahan3 == 0) $scope.messages.push({
						'message': "Tinggi tertanggung tambahan 3 harus benar! (50cm - 250cm)"
					});
					if ($scope.data.beratBadanTertanggungTambahan3 == 0) $scope.messages.push({
						'message': "Berat Badan tertanggung tambahan 3 harus benar! (10kg - 300kg)"
					});

					if($scope.data.isTertanggungTambahan3Bekerja){
						if($scope.data.namaKantorTertanggungTambahan3 == ''){
							$scope.messages.push({
								'message': "Nama Kantor tertanggung tambahan 3 harus benar!"
							});
						}

						if($scope.data.alamatKantorTertanggungTambahan3 == ''){
							$scope.messages.push({
								'message': "Alamat Kantor tertanggung tambahan 3 harus benar!"
							});
						}
					}
				}

				if($scope.data.jmlTertanggungTambahan == 4){
					/** Tertanggung Tmabahan 1 */
					if ($scope.data.hubunganTT1DenganTTU == '0') $scope.messages.push({
						'message': "Silahkan pilih hubungan tertanggung tambahan 1 dengan tertanggung utama"
					});

					if ($scope.data.jenisKelaminTertanggungTambahan1 == '0') $scope.messages.push({
						'message': "Jenis Kelamin tertanggung tambahan 1 harus benar!"
					});
					
					if ($scope.data.namaTertanggungTambahan1 == '') $scope.messages.push({
						'message': "Nama tertanggung tambahan harus 1 benar! (tidak boleh kosong)"
					});

					if ($scope.data.noKtpTertanggungTambahan1 == '') $scope.messages.push({
						'message': "Nomor KTP tertanggung tambahan 1 harus benar!"
					});

					if($scope.data.noKtpTertanggungTambahan1 != ''){
						if($scope.data.noKtpTertanggungTambahan1.length != 16){
							$scope.messages.push({
								'message': "Nomor KTP tertanggung tambahan 1 tidak sesuai! (16 digit)"
							});
						}
					}

					if ($scope.data.tglLahirTertanggungTambahan1 == '') $scope.messages.push({
						'message': "Tanggal lahir tertanggung tambahan 1 harus benar!"
					});
					
					if ($scope.data.tempatLahirTertanggungTambahan1 == '') $scope.messages.push({
						'message': "Tempat lahir tertanggung tambahan 1 harus benar! (tidak boleh kosong)"
					});
					if ($scope.data.tinggiBadanTertanggungTambahan1 == 0) $scope.messages.push({
						'message': "Tinggi tertanggung tambahan 1 harus benar! (50cm - 250cm)"
					});
					if ($scope.data.beratBadanTertanggungTambahan1 == 0) $scope.messages.push({
						'message': "Berat Badan tertanggung tambahan 1 harus benar! (10kg - 300kg)"
					});

					if($scope.data.isTertanggungTambahan1Bekerja){
						if($scope.data.namaKantorTertanggungTambahan1 == ''){
							$scope.messages.push({
								'message': "Nama Kantor tertanggung tambahan 1 harus benar!"
							});
						}

						if($scope.data.alamatKantorTertanggungTambahan1 == ''){
							$scope.messages.push({
								'message': "Alamat Kantor tertanggung tambahan 1 harus benar!"
							});
						}
					}

					/** Tertanggung Tambahan 2 */
					if ($scope.data.hubunganTT2DenganTTU == '0') $scope.messages.push({
						'message': "Silahkan pilih hubungan tertanggung tambahan 2 dengan tertanggung utama"
					});

					if ($scope.data.jenisKelaminTertanggungTambahan2 == '0') $scope.messages.push({
						'message': "Jenis Kelamin tertanggung tambahan 2 harus benar!"
					});
					
					if ($scope.data.namaTertanggungTambahan2 == '') $scope.messages.push({
						'message': "Nama tertanggung tambahan harus 2 benar! (tidak boleh kosong)"
					});

					if ($scope.data.noKtpTertanggungTambahan2 == '') $scope.messages.push({
						'message': "Nomor KTP tertanggung tambahan 2 harus benar!"
					});

					if($scope.data.noKtpTertanggungTambahan2 != ''){
						if($scope.data.noKtpTertanggungTambahan2.length != 16){
							$scope.messages.push({
								'message': "Nomor KTP tertanggung tambahan 2 tidak sesuai! (16 digit)"
							});
						}
					}

					if ($scope.data.tglLahirTertanggungTambahan2 == '') $scope.messages.push({
						'message': "Tanggal lahir tertanggung tambahan 2 harus benar!"
					});
					
					if ($scope.data.tempatLahirTertanggungTambahan2 == '') $scope.messages.push({
						'message': "Tempat lahir tertanggung tambahan 2 harus benar! (tidak boleh kosong)"
					});
					
					if ($scope.data.tinggiBadanTertanggungTambahan2 == 0) $scope.messages.push({
						'message': "Tinggi tertanggung tambahan 2 harus benar! (50cm - 250cm)"
					});
					if ($scope.data.beratBadanTertanggungTambahan2 == 0) $scope.messages.push({
						'message': "Berat Badan tertanggung tambahan 2 harus benar! (10kg - 300kg)"
					});

					if($scope.data.isTertanggungTambahan2Bekerja){
						if($scope.data.namaKantorTertanggungTambahan2 == ''){
							$scope.messages.push({
								'message': "Nama Kantor tertanggung tambahan 2 harus benar!"
							});
						}

						if($scope.data.alamatKantorTertanggungTambahan2 == ''){
							$scope.messages.push({
								'message': "Alamat Kantor tertanggung tambahan 2 harus benar!"
							});
						}
					}

					/** Tertanggung Tambahan 3 */
					if ($scope.data.hubunganTT3DenganTTU == '0') $scope.messages.push({
						'message': "Silahkan pilih hubungan tertanggung tambahan 3 dengan tertanggung utama"
					});

					if ($scope.data.jenisKelaminTertanggungTambahan3 == '0') $scope.messages.push({
						'message': "Jenis Kelamin tertanggung tambahan 3 harus benar!"
					});
					
					if ($scope.data.namaTertanggungTambahan3 == '') $scope.messages.push({
						'message': "Nama tertanggung tambahan harus 3 benar! (tidak boleh kosong)"
					});

					if ($scope.data.noKtpTertanggungTambahan3 == '') $scope.messages.push({
						'message': "Nomor KTP tertanggung tambahan 3 harus benar!"
					});

					if($scope.data.noKtpTertanggungTambahan3 != ''){
						if($scope.data.noKtpTertanggungTambahan3.length != 16){
							$scope.messages.push({
								'message': "Nomor KTP tertanggung tambahan 3 tidak sesuai! (16 digit)"
							});
						}
					}

					if ($scope.data.tglLahirTertanggungTambahan3 == '') $scope.messages.push({
						'message': "Tanggal lahir tertanggung tambahan 3 harus benar!"
					});
					
					if ($scope.data.tempatLahirTertanggungTambahan3 == '') $scope.messages.push({
						'message': "Tempat lahir tertanggung tambahan 3 harus benar! (tidak boleh kosong)"
					});
					if ($scope.data.tinggiBadanTertanggungTambahan3 == 0) $scope.messages.push({
						'message': "Tinggi tertanggung tambahan 3 harus benar! (50cm - 250cm)"
					});
					if ($scope.data.beratBadanTertanggungTambahan3 == 0) $scope.messages.push({
						'message': "Berat Badan tertanggung tambahan 3 harus benar! (10kg - 300kg)"
					});

					if($scope.data.isTertanggungTambahan3Bekerja){
						if($scope.data.namaKantorTertanggungTambahan3 == ''){
							$scope.messages.push({
								'message': "Nama Kantor tertanggung tambahan 3 harus benar!"
							});
						}

						if($scope.data.alamatKantorTertanggungTambahan3 == ''){
							$scope.messages.push({
								'message': "Alamat Kantor tertanggung tambahan 3 harus benar!"
							});
						}
					}

					/** Tertanggung Tambahan 4 */
					if ($scope.data.hubunganTT4DenganTTU == '0') $scope.messages.push({
						'message': "Silahkan pilih hubungan tertanggung tambahan 4 dengan tertanggung utama"
					});

					if ($scope.data.jenisKelaminTertanggungTambahan4 == '0') $scope.messages.push({
						'message': "Jenis Kelamin tertanggung tambahan 4 harus benar!"
					});
					
					if ($scope.data.namaTertanggungTambahan4 == '') $scope.messages.push({
						'message': "Nama tertanggung tambahan harus 4 benar! (tidak boleh kosong)"
					});

					if ($scope.data.noKtpTertanggungTambahan4 == '') $scope.messages.push({
						'message': "Nomor KTP tertanggung tambahan 4 harus benar!"
					});

					if($scope.data.noKtpTertanggungTambahan4 != ''){
						if($scope.data.noKtpTertanggungTambahan4.length != 16){
							$scope.messages.push({
								'message': "Nomor KTP tertanggung tambahan 4 tidak sesuai! (16 digit)"
							});
						}
					}

					if ($scope.data.tglLahirTertanggungTambahan4 == '') $scope.messages.push({
						'message': "Tanggal lahir tertanggung tambahan 4 harus benar!"
					});
					
					if ($scope.data.tempatLahirTertanggungTambahan4 == '') $scope.messages.push({
						'message': "Tempat lahir tertanggung tambahan 4 harus benar! (tidak boleh kosong)"
					});
					if ($scope.data.tinggiBadanTertanggungTambahan4 == 0) $scope.messages.push({
						'message': "Tinggi tertanggung tambahan 4 harus benar! (50cm - 250cm)"
					});
					if ($scope.data.beratBadanTertanggungTambahan4 == 0) $scope.messages.push({
						'message': "Berat Badan tertanggung tambahan 4 harus benar! (10kg - 300kg)"
					});

					if($scope.data.isTertanggungTambahan4Bekerja){
						if($scope.data.namaKantorTertanggungTambahan4 == ''){
							$scope.messages.push({
								'message': "Nama Kantor tertanggung tambahan 4 harus benar!"
							});
						}

						if($scope.data.alamatKantorTertanggungTambahan4 == ''){
							$scope.messages.push({
								'message': "Alamat Kantor tertanggung tambahan 4 harus benar!"
							});
						}
					}
				}
				// if ($scope.data.isAdaTertanggungTambahan1) {

				// 	if ($scope.data.hubunganTT1DenganTTU == '0') $scope.messages.push({
				// 		'message': "Silahkan pilih hubungan tertanggung tambahan 1 dengan tertanggung utama"
				// 	});

				// 	if ($scope.data.jenisKelaminTertanggungTambahan1 == '0') $scope.messages.push({
				// 		'message': "Jenis Kelamin tertanggung tambahan 1 harus benar!"
				// 	});
					
				// 	if ($scope.data.namaTertanggungTambahan1 == '') $scope.messages.push({
				// 		'message': "Nama tertanggung tambahan harus 1 benar! (tidak boleh kosong)"
				// 	});

				// 	if ($scope.data.noKtpTertanggungTambahan1 == '') $scope.messages.push({
				// 		'message': "Nomor KTP tertanggung tambahan 1 harus benar!"
				// 	});

				// 	if($scope.data.noKtpTertanggungTambahan1 != ''){
				// 		if($scope.data.noKtpTertanggungTambahan1.length != 16){
				// 			$scope.messages.push({
				// 				'message': "Nomor KTP tertanggung tambahan 1 tidak sesuai! (16 digit)"
				// 			});
				// 		}
				// 	}

				// 	if ($scope.data.tglLahirTertanggungTambahan1 == '') $scope.messages.push({
				// 		'message': "Tanggal lahir tertanggung tambahan 1 harus benar!"
				// 	});
					
				// 	if ($scope.data.tempatLahirTertanggungTambahan1 == '') $scope.messages.push({
				// 		'message': "Tempat lahir tertanggung tambahan 1 harus benar! (tidak boleh kosong)"
				// 	});
					
				// 	//if($scope.data.namaKantorTertanggungTambahan1 == '')$scope.messages.push({'message':"Nama Kantor tertanggung tambahan harus benar!"});
				// 	//if($scope.data.alamatKantorTertanggungTambahan1 == '')$scope.messages.push({'message':"Alamat kantor tertanggung tambahan harus benar!"});
				// 	if ($scope.data.tinggiBadanTertanggungTambahan1 == 0) $scope.messages.push({
				// 		'message': "Tinggi tertanggung tambahan 1 harus benar! (50cm - 250cm)"
				// 	});
				// 	if ($scope.data.beratBadanTertanggungTambahan1 == 0) $scope.messages.push({
				// 		'message': "Berat Badan tertanggung tambahan 1 harus benar! (10kg - 300kg)"
				// 	});

				// 	if($scope.data.isTertanggungTambahan1Bekerja){
				// 		if($scope.data.namaKantorTertanggungTambahan1 == ''){
				// 			$scope.messages.push({
				// 				'message': "Nama Kantor tertanggung tambahan 1 harus benar!"
				// 			});
				// 		}

				// 		if($scope.data.alamatKantorTertanggungTambahan1 == ''){
				// 			$scope.messages.push({
				// 				'message': "Alamat Kantor tertanggung tambahan 1 harus benar!"
				// 			});
				// 		}
				// 	}
				// }

				// if ($scope.data.jmlTertanggungTambahan == 2) {

				// 	if ($scope.data.hubunganTT2DenganTTU == '0') $scope.messages.push({
				// 		'message': "Silahkan pilih hubungan tertanggung tambahan 2 dengan tertanggung utama"
				// 	});

				// 	if ($scope.data.jenisKelaminTertanggungTambahan2 == '0') $scope.messages.push({
				// 		'message': "Jenis Kelamin tertanggung tambahan 2 harus benar!"
				// 	});
					
				// 	if ($scope.data.namaTertanggungTambahan2 == '') $scope.messages.push({
				// 		'message': "Nama tertanggung tambahan harus 2 benar! (tidak boleh kosong)"
				// 	});

				// 	if ($scope.data.noKtpTertanggungTambahan2 == '') $scope.messages.push({
				// 		'message': "Nomor KTP tertanggung tambahan 2 harus benar!"
				// 	});

				// 	if($scope.data.noKtpTertanggungTambahan2 != ''){
				// 		if($scope.data.noKtpTertanggungTambahan2.length != 16){
				// 			$scope.messages.push({
				// 				'message': "Nomor KTP tertanggung tambahan 2 tidak sesuai! (16 digit)"
				// 			});
				// 		}
				// 	}

				// 	if ($scope.data.tglLahirTertanggungTambahan2 == '') $scope.messages.push({
				// 		'message': "Tanggal lahir tertanggung tambahan 2 harus benar!"
				// 	});
					
				// 	if ($scope.data.tempatLahirTertanggungTambahan2 == '') $scope.messages.push({
				// 		'message': "Tempat lahir tertanggung tambahan 2 harus benar! (tidak boleh kosong)"
				// 	});
					
				// 	//if($scope.data.namaKantorTertanggungTambahan2 == '')$scope.messages.push({'message':"Nama Kantor tertanggung tambahan harus benar!"});
				// 	//if($scope.data.alamatKantorTertanggungTambahan2 == '')$scope.messages.push({'message':"Alamat kantor tertanggung tambahan harus benar!"});
				// 	if ($scope.data.tinggiBadanTertanggungTambahan2 == 0) $scope.messages.push({
				// 		'message': "Tinggi tertanggung tambahan 2 harus benar! (50cm - 250cm)"
				// 	});
				// 	if ($scope.data.beratBadanTertanggungTambahan2 == 0) $scope.messages.push({
				// 		'message': "Berat Badan tertanggung tambahan 2 harus benar! (10kg - 300kg)"
				// 	});

				// 	if($scope.data.isTertanggungTambahan2Bekerja){
				// 		if($scope.data.namaKantorTertanggungTambahan2 == ''){
				// 			$scope.messages.push({
				// 				'message': "Nama Kantor tertanggung tambahan 2 harus benar!"
				// 			});
				// 		}

				// 		if($scope.data.alamatKantorTertanggungTambahan2 == ''){
				// 			$scope.messages.push({
				// 				'message': "Alamat Kantor tertanggung tambahan 2 harus benar!"
				// 			});
				// 		}
				// 	}
				// }

				// if ($scope.data.jmlTertanggungTambahan == 3) {

				// 	if ($scope.data.hubunganTT3DenganTTU == '0') $scope.messages.push({
				// 		'message': "Silahkan pilih hubungan tertanggung tambahan 3 dengan tertanggung utama"
				// 	});

				// 	if ($scope.data.jenisKelaminTertanggungTambahan3 == '0') $scope.messages.push({
				// 		'message': "Jenis Kelamin tertanggung tambahan 3 harus benar!"
				// 	});
					
				// 	if ($scope.data.namaTertanggungTambahan3 == '') $scope.messages.push({
				// 		'message': "Nama tertanggung tambahan harus 3 benar! (tidak boleh kosong)"
				// 	});

				// 	if ($scope.data.noKtpTertanggungTambahan3 == '') $scope.messages.push({
				// 		'message': "Nomor KTP tertanggung tambahan 3 harus benar!"
				// 	});

				// 	if($scope.data.noKtpTertanggungTambahan3 != ''){
				// 		if($scope.data.noKtpTertanggungTambahan3.length != 16){
				// 			$scope.messages.push({
				// 				'message': "Nomor KTP tertanggung tambahan 3 tidak sesuai! (16 digit)"
				// 			});
				// 		}
				// 	}

				// 	if ($scope.data.tglLahirTertanggungTambahan3 == '') $scope.messages.push({
				// 		'message': "Tanggal lahir tertanggung tambahan 3 harus benar!"
				// 	});
					
				// 	if ($scope.data.tempatLahirTertanggungTambahan3 == '') $scope.messages.push({
				// 		'message': "Tempat lahir tertanggung tambahan 3 harus benar! (tidak boleh kosong)"
				// 	});
					
				// 	//if($scope.data.namaKantorTertanggungTambahan3 == '')$scope.messages.push({'message':"Nama Kantor tertanggung tambahan harus benar!"});
				// 	//if($scope.data.alamatKantorTertanggungTambahan3 == '')$scope.messages.push({'message':"Alamat kantor tertanggung tambahan harus benar!"});
				// 	if ($scope.data.tinggiBadanTertanggungTambahan3 == 0) $scope.messages.push({
				// 		'message': "Tinggi tertanggung tambahan 3 harus benar! (50cm - 250cm)"
				// 	});
				// 	if ($scope.data.beratBadanTertanggungTambahan3 == 0) $scope.messages.push({
				// 		'message': "Berat Badan tertanggung tambahan 3 harus benar! (10kg - 300kg)"
				// 	});

				// 	if($scope.data.isTertanggungTambahan3Bekerja){
				// 		if($scope.data.namaKantorTertanggungTambahan3 == ''){
				// 			$scope.messages.push({
				// 				'message': "Nama Kantor tertanggung tambahan 3 harus benar!"
				// 			});
				// 		}

				// 		if($scope.data.alamatKantorTertanggungTambahan3 == ''){
				// 			$scope.messages.push({
				// 				'message': "Alamat Kantor tertanggung tambahan 3 harus benar!"
				// 			});
				// 		}
				// 	}
				// }

				// if ($scope.data.jmlTertanggungTambahan == 4) {

				// 	if ($scope.data.hubunganTT4DenganTTU == '0') $scope.messages.push({
				// 		'message': "Silahkan pilih hubungan tertanggung tambahan 4 dengan tertanggung utama"
				// 	});

				// 	if ($scope.data.jenisKelaminTertanggungTambahan4 == '0') $scope.messages.push({
				// 		'message': "Jenis Kelamin tertanggung tambahan 4 harus benar!"
				// 	});
					
				// 	if ($scope.data.namaTertanggungTambahan4 == '') $scope.messages.push({
				// 		'message': "Nama tertanggung tambahan harus 4 benar! (tidak boleh kosong)"
				// 	});

				// 	if ($scope.data.noKtpTertanggungTambahan4 == '') $scope.messages.push({
				// 		'message': "Nomor KTP tertanggung tambahan 4 harus benar!"
				// 	});

				// 	if($scope.data.noKtpTertanggungTambahan4 != ''){
				// 		if($scope.data.noKtpTertanggungTambahan4.length != 16){
				// 			$scope.messages.push({
				// 				'message': "Nomor KTP tertanggung tambahan 4 tidak sesuai! (16 digit)"
				// 			});
				// 		}
				// 	}

				// 	if ($scope.data.tglLahirTertanggungTambahan4 == '') $scope.messages.push({
				// 		'message': "Tanggal lahir tertanggung tambahan 4 harus benar!"
				// 	});
					
				// 	if ($scope.data.tempatLahirTertanggungTambahan4 == '') $scope.messages.push({
				// 		'message': "Tempat lahir tertanggung tambahan 4 harus benar! (tidak boleh kosong)"
				// 	});
					
				// 	//if($scope.data.namaKantorTertanggungTambahan4 == '')$scope.messages.push({'message':"Nama Kantor tertanggung tambahan harus benar!"});
				// 	//if($scope.data.alamatKantorTertanggungTambahan4 == '')$scope.messages.push({'message':"Alamat kantor tertanggung tambahan harus benar!"});
				// 	if ($scope.data.tinggiBadanTertanggungTambahan4 == 0) $scope.messages.push({
				// 		'message': "Tinggi tertanggung tambahan 4 harus benar! (50cm - 250cm)"
				// 	});
				// 	if ($scope.data.beratBadanTertanggungTambahan4 == 0) $scope.messages.push({
				// 		'message': "Berat Badan tertanggung tambahan 4 harus benar! (10kg - 300kg)"
				// 	});

				// 	if($scope.data.isTertanggungTambahan4Bekerja){
				// 		if($scope.data.namaKantorTertanggungTambahan4 == ''){
				// 			$scope.messages.push({
				// 				'message': "Nama Kantor tertanggung tambahan 4 harus benar!"
				// 			});
				// 		}

				// 		if($scope.data.alamatKantorTertanggungTambahan4 == ''){
				// 			$scope.messages.push({
				// 				'message': "Alamat Kantor tertanggung tambahan 4 harus benar!"
				// 			});
				// 		}
				// 	}
				// }
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			if ($scope.messages.length > 0) {
				return $scope.messages;
			}
			return false;
		}
		$scope.copyTertanggung1FromPempol = function() {
			if ($scope.data.isTertanggungTambahan1Pempol) {
				$scope.data.jenisKelaminTertanggungTambahan1 = prospek.kdjeniskelamincpp;
				$scope.data.namaTertanggungTambahan1 = prospek.namacpp;
				$scope.data.noKtpTertanggungTambahan1 = prospek.noktpcpp;
				$scope.data.tglLahirTertanggungTambahan1 = prospek.tgllahircpp;
			} else {
				$scope.data.jenisKelaminTertanggungTambahan1 = $scope.genders[0].id;
				$scope.data.hubunganTT1DenganTTU = $scope.hubunganKeluargas[0].id;
				$scope.data.namaTertanggungTambahan1 = '';
				$scope.data.noKtpTertanggungTambahan1 = '';
				$scope.data.tglLahirTertanggungTambahan1 = $scope.tglLahirTertanggungTambahan1;
			}
		}
		$scope.copyTertanggung2FromPempol = function() {
			if ($scope.data.isTertanggungTambahan2Pempol) {
				$scope.data.jenisKelaminTertanggungTambahan2 = prospek.kdjeniskelamincpp;
				$scope.data.namaTertanggungTambahan2 = prospek.namacpp;
				$scope.data.noKtpTertanggungTambahan2 = prospek.noktpcpp;
				$scope.data.tglLahirTertanggungTambahan2 = prospek.tgllahircpp;
			} else {
				$scope.data.jenisKelaminTertanggungTambahan2 = $scope.genders[0].id;
				$scope.data.hubunganTT2DenganTTU = $scope.hubunganKeluargas[0].id;
				$scope.data.namaTertanggungTambahan2 = '';
				$scope.data.noKtpTertanggungTambahan2 = '';
				$scope.data.tglLahirTertanggungTambahan2 = $scope.tglLahirTertanggungTambahan2;
			}
		}
		$scope.copyTertanggung3FromPempol = function() {
			if ($scope.data.isTertanggungTambahan3Pempol) {
				$scope.data.jenisKelaminTertanggungTambahan3 = prospek.kdjeniskelamincpp;
				$scope.data.namaTertanggungTambahan3 = prospek.namacpp;
				$scope.data.noKtpTertanggungTambahan3 = prospek.noktpcpp;
				$scope.data.tglLahirTertanggungTambahan3 = prospek.tgllahircpp;
			} else {
				$scope.data.jenisKelaminTertanggungTambahan3 = $scope.genders[0].id;
				$scope.data.hubunganTT3DenganTTU = $scope.hubunganKeluargas[0].id;
				$scope.data.namaTertanggungTambahan3 = '';
				$scope.data.noKtpTertanggungTambahan3 = '';
				$scope.data.tglLahirTertanggungTambahan3 = $scope.tglLahirTertanggungTambahan2;
			}
		}
		$scope.copyTertanggung4FromPempol = function() {
			if ($scope.data.isTertanggungTambahan4Pempol) {
				$scope.data.jenisKelaminTertanggungTambahan4 = prospek.kdjeniskelamincpp;
				$scope.data.namaTertanggungTambahan4 = prospek.namacpp;
				$scope.data.noKtpTertanggungTambahan4 = prospek.noktpcpp;
				$scope.data.tglLahirTertanggungTambahan4 = prospek.tgllahircpp;
			} else {
				$scope.data.jenisKelaminTertanggungTambahan4 = $scope.genders[0].id;
				$scope.data.hubunganTT4DenganTTU = $scope.hubunganKeluargas[0].id;
				$scope.data.namaTertanggungTambahan4 = '';
				$scope.data.noKtpTertanggungTambahan4 = '';
				$scope.data.tglLahirTertanggungTambahan4 = $scope.tglLahirTertanggungTambahan2;
			}
		}
	}
])
////////// PAGE 3
//////////
.controller('dataPemegangPolis13Ctrl', ['$state', '$scope', '$stateParams', 'dataFactory', 'spajProvider', '$ionicPopup', 'syncService', '$store',
	function ($state, $scope, $stateParams, dataFactory, spajProvider, $ionicPopup, syncService, $store) {
		$scope.genders = dataFactory.getGenders();
		$scope.agamas = dataFactory.getAgamas();
		$scope.statuss = dataFactory.getStatusNikahs();
		$scope.pendidikans = dataFactory.getPendidikans();
		$scope.hubunganKeluargas = dataFactory.getHubunganKeluargas();
		// $scope.data.imageKTPpempol = null;
		$scope.data = {
			'imageKTPpempol' : null
		}
		console.log($scope.data.imageKTPpempol);
		$scope.$on('$ionicView.beforeEnter', function (event, viewData) {
			viewData.enableBack = true;
		});

		$scope.doCopyTertanggungToPempol = function(){
			$scope.pempolAdalahTertanggung();
			$scope.reattachImageKTPPempol();
		}

		$scope.labelIsPempolTertanggungHide = false;

		//UAT 10 January 2023
		$scope.$on('$ionicView.loaded', function(){
			if( prospek.kd_produk.match(/APP/i) ) {
				$scope.data.isTertanggungPempol = true;
				$scope.doCopyTertanggungToPempol();
				
				//UAT 18 January 2023
				$scope.labelIsPempolTertanggungHide = true;
				
			}else{
				$scope.labelIsPempolTertanggungHide = false;
			}
		});
		
		//INIT FORM 
		prospek = false;
		try {
			$pros = JSON.parse(spajProvider.getProspekData());
			prospek = $pros.find(obj => {
				return obj.build_id === spajProvider.getBuildId()
			});
		} catch (e) {
			prospek = {
				'kdprovinsi': '0',
				'alamat': ''
			}
		}

		$scope.changeImage = function () {
			spajProvider.takePict(this, 'canvasKTPpempol');
			$scope.data.imageKTPpempol = spajProvider.getImageBase64('canvasKTPpempol', 'jpg');
			
		}

		$scope.saveDataSpaj = function () {
			if($scope.data.imageKTPpempol != null){
				$scope.data.imageKTPpempol = spajProvider.getImageBase64('canvasKTPpempol', 'jpg');
			}
			
			let $formdata = {
				'pageId': 'aplikasiSPAJOnline.dataPemegangPolis13',
				'data': $scope.data
			};
			spajProvider.setSpajGUID($scope.data.spaj_guid);
			$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + $formdata.pageId, $scope.data);
			spajProvider.setSpajElement($formdata);
			//$scope.showAlert('Test Display',angular.toJson(spajProvider.getSpajElement(), true));
		}

		// $scope.changeImage = function () {
		// 	spajProvider.takePict(this, 'canvasKTPpempol');
		// 	$scope.data.imageKTPpempol = spajProvider.getImageBase64('canvasKTPpempol', 'jpg');
			
		// }

		if ($store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataPemegangPolis13') == null) {
			$scope.data = {
				'spaj_guid': spajProvider.getSpajGUID(),
				'agamaPempol': $scope.agamas[0].id,
				'jenkelPempol': prospek.kdjeniskelamincpp,
				'isKTPPempolAllAge': false,
				'isPagePempol1Accepted': false,
				'namaLengkapPempol': prospek.namacpp,
				'nomorKTPPempol': prospek.noktpcpp,
				'tglLahirPempol': prospek.tgllahircpp,
				'nomorNPWPPempol': '',
				'masaBerlakuKTPPempol': '',
				'imageKTPpempol': null,
				'isTertanggungPempol': false,
				'isPempolPembayarPremi': true
			}
		} else {
			$scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataPemegangPolis13');
			//decodedImage = null;
			try {
				decodedImage = spajProvider.ioBase64.decode(spajProvider.ioBase64.decode($scope.data.imageKTPpempol));
				// console.log('disini')
			} catch (e) {
				console.log(e);
			}
			$scope.data.tglLahirPempol = new Date($scope.data.tglLahirPempol);
			spajProvider.putImageTo('canvasKTPpempol', decodedImage);
		}

		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {
				//console.log('Thank you for not eating my delicious ice cream cone');
			});
		};

		$scope.reattachImageKTPPempol = function(){
			let imageKTPpempol = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung13').imageKTPTertanggung;
			
			let decodedImage = spajProvider.ioBase64.decode(spajProvider.ioBase64.decode(imageKTPpempol));
			spajProvider.putImageTo('canvasKTPpempol', decodedImage);
		}

		$scope.pempolAdalahTertanggung = function () {
			let $tertanggung = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung13');
			let $tertanggungPage2 = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung23');
			let $tertanggungPage3 = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung33');
			let $tertanggungPekerjaan = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.pekerjaanTertanggung');
			let $pempol = this.data;
			let $pgTertanggung2 = null;
			let $pgTertanggung3 = null;
			
			if ($scope.data.isTertanggungPempol && $tertanggung != null) {
				$pempol.namaLengkapPempol = $tertanggung.namaLengkapTertanggung;
				$pempol.namaAliasPempol = $tertanggung.namaAliasTertanggung;
				$pempol.nomorKTPPempol = $tertanggung.nomorKTPTertanggung;
				$pempol.nomorNPWPPempol = $tertanggung.nomorNPWPTertanggung;
				$pempol.jenkelPempol = $tertanggung.jenkelTertanggung;
				$pempol.agamaPempol = $tertanggung.agamaTertanggung;
				$pempol.imageKTPpempol = $tertanggung.imageKTPTertanggung;

				if( !prospek.kd_produk.match(/APP/i) ) {
					$scope.reattachImageKTPPempol();
				}
				
				$pempol.isPagePempol1Accepted = false;
				$pempol.isTertanggungPempol = true;
				$pempol.tglLahirPempol = new Date($tertanggung.tglLahirTertanggung)
				$pempol.tempatLahirPempol = $tertanggung.tempatLahirTertanggung
				//console.log($tertanggungPage2.tglLahirTertanggung);
				$pgTertanggung2 = {
					'spaj_guid': spajProvider.getSpajGUID(),
					'provinsiKTPPempol': $tertanggungPage2.provinsiKTPtertanggung,
					'provinsiSuratPempol': $tertanggungPage2.provinsiSurattertanggung,
					'statusTinggalKTPPempol': $tertanggungPage2.statusTinggalKTPtertanggung,
					'statusTinggalSuratPempol': $tertanggungPage2.statusTinggalSurattertanggung,
					'alamatKTPPempol': $tertanggungPage2.alamatKTPtertanggung,
					'tglLahirPempol': $scope.tglLahirPempol,
					'kabupatenKTPPempol': $tertanggungPage2.kabupatenKTPtertanggung,
					'kodeposKTPPempol': $tertanggungPage2.kodeposKTPtertanggung,
					'isAlamatKTPPempolSama': $tertanggungPage2.isAlamatKTPtertanggungSama,
					'alamatSuratPempol': $tertanggungPage2.alamatSurattertanggung,
					'kabupatenSuratPempol': $tertanggungPage2.kabupatenSurattertanggung,
					'kodeposSuratPempol': $tertanggungPage2.kodeposSurattertanggung,
					'nomorHpPempol': $tertanggungPage2.nomorHptertanggung,
					'nomorTelpPempol': $tertanggungPage2.nomorTelptertanggung,
					'emailPempol': $tertanggungPage2.emailtertanggung,
					'isSetujuHPPempol': $tertanggungPage2.isSetujuHPtertanggung,
					'isSetujuEmailPempol': $tertanggungPage2.isSetujuEmailtertanggung,
					'isPagePempol2Accepted': false
				}
				$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + 'aplikasiSPAJOnline.dataPemegangPolis23', $pgTertanggung2);
				$pgTertanggung3 = {
					'spaj_guid': spajProvider.getSpajGUID(),
					'provinsiSuratTakSerumahPempol': $tertanggungPage3.provinsiSuratSaudaraTertanggung,
					'hubdgnTertanggung' : $tertanggungPekerjaan.hubdgnPempol,
					'statusNikahPempol': $tertanggungPage3.statusPernikahanTertanggung,
					'pendidikanPempol': $tertanggungPage3.pendidikanTertanggung,
					'tinggiBadanPempol': $tertanggungPage3.tinggiBadanTertanggung,
					'beratBadanPempol': $tertanggungPage3.beratBadanTertanggung,
					'namaIbuPempol': $tertanggungPage3.ibuKandungTertanggung,
					'namaSaudaraTakSerumahPempol': $tertanggungPage3.namaSaudaraTertanggung,
					'alamatSuratTakSerumahPempol': $tertanggungPage3.alamatSuratSaudaraTertanggung,
					'kabupatenTakSerumahPempol': $tertanggungPage3.kabupatenSuratSaudaraTertanggung,
					'kodeposSuratSaudaraTertanggung': $tertanggungPage3.kodeposSuratSaudaraTertanggung,
					'kodeposTakSerumahPempol': $tertanggungPage3.kodeposSuratSaudaraTertanggung,
					'noHPTakSerumah': $tertanggungPage3.noHpSaudaraTertanggung,
					'noTelTakSerumah': $tertanggungPage3.noTelpSaudaraTertanggung,
					'isPagePempol3Accepted': false,
					'isTertanggungPempol': true
				}
				$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + 'aplikasiSPAJOnline.dataPemegangPolis33', $pgTertanggung3);
				$pgPekerjaanPempol = {
					'spaj_guid': spajProvider.getSpajGUID(),
					'jenisPerusahaanPempol': $tertanggungPekerjaan.jenisPerusahaanTertanggung,
					'penghasilanPempol' : $tertanggungPekerjaan.penghasilanTertanggung,
					'jenisPendapatanPempol' : $tertanggungPekerjaan.jenisPendapatan,
					'pekerjaanPempol': $tertanggungPekerjaan.pekerjaanTertanggung,
					'pangkatPempol': $tertanggungPekerjaan.pangkatTertanggung,
					'klasifikasiPekerjaanPempol': $tertanggungPekerjaan.klasifikasiPekerjaanTertanggung,
					'rangeGajiPempol': $tertanggungPekerjaan.rangeGajiTertanggung,
					'rangeGajiPempolJmlLainnya': $tertanggungPekerjaan.rangeGajiTertanggungJmlLainnya,
					'rangePendapatanPempol': $tertanggungPekerjaan.rangePendapatanTertanggung,
					'rangePendapatanPasanganPempol': $tertanggungPekerjaan.rangePendapatanPasangan,
					'rangePendapatanPasanganPempolLainnya': $tertanggungPekerjaan.rangePendapatanPasanganLainnya,
					'usiaProduktifPasanganPempol' : $tertanggungPekerjaan.usiaProduktifPasangan,
					'rangeHasilInvestasiPempol' : $tertanggungPekerjaan.rangeHasilInvestasi,
					'rangeHasilInvestasiPempolLainnya' : $tertanggungPekerjaan.rangeHasilInvestasiLainnya,
					'rangeBisnisPempol' : $tertanggungPekerjaan.rangeBisnis,
					'rangeBisnisPempolLainnya' : $tertanggungPekerjaan.rangeBisnisLainnya,
					'rangeBonusPempol' : $tertanggungPekerjaan.rangeBonus,
					'rangeBonusPempolLainnya' : $tertanggungPekerjaan.rangeBonusLainnya,
					'rangePendapatanOrangTuaPempol' : $tertanggungPekerjaan.rangePendapatanOrangTua,
					'rangePendapatanOrangTuaPempolLainnya' : $tertanggungPekerjaan.rangePendapatanOrangTuaLainnya,
					'usiaProduktifOrangTuaPempol' : $tertanggungPekerjaan.usiaProduktifOrangTua,
					'rangePendapatanPempol' : $tertanggungPekerjaan.rangePendapatanTertanggung,
					'rangePendapatanPempolLainnya' : $tertanggungPekerjaan.rangePendapatanTertanggungLainnya,
					'sumberPendapatanPempolLainnya' : $tertanggungPekerjaan.sumberPendapatanLainnya,
					'klasifikasiPekerjaanPempol' : $tertanggungPekerjaan.klasifikasiPekerjaanTertanggung,
					'namaPerusahaanPempol': $tertanggungPekerjaan.namaPerusahaanTertanggung,
					'alamatPerusahaanPempol': $tertanggungPekerjaan.alamatPerusahaanTertanggung,
					'kodeposPerusahaanPempol': $tertanggungPekerjaan.kodeposPerusahaanTertanggung,
					'nomorTeleponPerusahaanPempol': $tertanggungPekerjaan.nomorTeleponPerusahaanTertanggung,
					'nomorEkstensiPerusahaanPempol': $tertanggungPekerjaan.nomorEkstensiPerusahaanTertanggung,
					'isPagePekerjaanPempol1Accepted': '',
					'pemilikWirausahaPempol': $tertanggungPekerjaan.pemilikWirausahaTertanggung,
					'bidangWirausahaPempol': $tertanggungPekerjaan.bidangWirausahaTertanggung,
					'namaWirausahaPempol': $tertanggungPekerjaan.namaWirausahaTertanggung,
					'alamatWirausahaPempol': $tertanggungPekerjaan.alamatWirausahaTertanggung
				}
				$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + 'aplikasiSPAJOnline.pekerjaanPemegangPolis', $pgPekerjaanPempol);
				this.saveDataSpaj();
			} else {
				$pempol.namaLengkapPempol = prospek.namacpp;
				$pempol.namaAliasPempol = '';
				$pempol.tglLahirPempol = prospek.tgllahircpp;
				$pempol.nomorKTPPempol = prospek.noktpcpp;
				$pempol.nomorNPWPPempol = '';
				$pempol.jenkelPempol = prospek.kdjeniskelamincpp;
				$pempol.agamaPempol = '';
				$pempol.imageKTPpempol = '';
				$pempol.isPagePempol1Accepted = false;
				$pempol.isTertanggungPempol = false;
				$pgTertanggung2 = {
					'spaj_guid': spajProvider.getSpajGUID(),
					'provinsiKTPPempol': prospek.kdpropinsicpp,
					'provinsiSuratPempol': '0',
					'statusTinggalKTPPempol': '0',
					'statusTinggalSuratPempol': '0',
					'tglLahirPempol': '',
					'alamatKTPPempol': prospek.alamatcpp,
					'kabupatenKTPPempol': prospek.kdkotamadyacpp,
					'kodeposKTPPempol': prospek.kdposcpp,
					'isAlamatKTPPempolSama': false,
					'alamatSuratPempol': '',
					'kabupatenSuratPempol': '',
					'kodeposSuratPempol': '',
					'nomorHpPempol': prospek.hpcpp,
					'nomorTelpPempol': prospek.teleponcpp,
					'emailPempol': prospek.emailcpp,
					'isSetujuHPPempol': false,
					'isSetujuEmailPempol': false,
					'isPagePempol2Accepted': false
				}
				$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + 'aplikasiSPAJOnline.dataPemegangPolis23', $pgTertanggung2);
				$pgTertanggung3 = {
					'spaj_guid': spajProvider.getSpajGUID(),
					'provinsiSuratTakSerumahPempol': '0',
					'statusNikahPempol': '0',
					'pendidikanPempol': '',
					'tinggiBadanPempol': '',
					'beratBadanPempol': '',
					'namaIbuPempol': '',
					'namaTakSerumahPempol': '',
					'alamatSuratTakSerumahPempol': '',
					'kabupatenTakSerumahPempol': '',
					'kodeposSuratSaudaraTertanggung': '',
					'kodeposTakSerumahPempol': '',
					'noHPTakSerumah': '',
					'noTelTakSerumah': '',
					'isPagePempol3Accepted': false,
					'isTertanggungPempol': false
				}
				$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + 'aplikasiSPAJOnline.dataPemegangPolis33', $pgTertanggung3);
				this.saveDataSpaj();
			}
		}

		$scope.isPageAccepted = function () {
			if (!$scope.data.isPagePempol1Accepted) {
				$scope.showAlert('Apakah data sudah benar?', 'Pastikan Anda yakin data sudah benar untuk melanjutkan kehalaman berikutnya.');
				return false;
			}
		}

		let $tertanggungPage3 = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung33');
		let $pgTertanggungCopy3 = null;
		if($tertanggungPage3.isTertanggungTambahan1Pempol){
			$scope.data.tempatLahirPempol = $tertanggungPage3.tempatLahirTertanggungTambahan1;

			$pgTertanggungCopy3 = {
				'spaj_guid': spajProvider.getSpajGUID(),
				'provinsiSuratTakSerumahPempol': $tertanggungPage3.provinsiSuratSaudaraTertanggung,
				'hubdgnTertanggung' : $tertanggungPage3.hubunganTT1DenganTTU,
				'tinggiBadanPempol':  $tertanggungPage3.tinggiBadanTertanggungTambahan1,
				'beratBadanPempol': $tertanggungPage3.beratBadanTertanggungTambahan1,
				'statusNikahPempol': $scope.statuss[0].id,
				'pendidikanPempol': $scope.pendidikans[0].id,
				'namaIbuPempol' : ''
				
			}

			// $scope.data.hubdgnTertanggung = $tertanggungPage3.hubunganTT1DenganTTU;
			// $scope.data.tinggiBadanPempol = $tertanggungPage3.tinggiBadanTertanggungTambahan1;
			// $scope.data.beratBadanPempol = $tertanggungPage3.beratBadanTertanggungTambahan1;
			$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + 'aplikasiSPAJOnline.dataPemegangPolis33', $pgTertanggungCopy3);
		}

		$scope.validateThisFormOnPageAccept = function () {

			//validate datanya
			$scope.messages = [];
			try {
				if ($scope.data == null) {
					$scope.messages.push({
						"message": "Data ERROR. Null data."
					});
				}
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			//validate nama, NOMOR KTP NPWP
			try {
				console.log($scope.data.imageKTPpempol);
				tryMe = $scope.data.namaLengkapPempol;
				if (tryMe == '') {
					$scope.messages.push({
						'message': "Nama Tertanggung harus benar!"
					});
				}
				tryMe = $scope.data.nomorKTPPempol;
				if (tryMe == '' && !(tryMe.match(/^\d+$/)) && $scope.data.nomorKTPPempol.length != 16) {
					$scope.messages.push({
						'message': "Nomor KTP harus benar! (16 digit)"
					});
				}
				// tryMe = $scope.data.nomorNPWPTertanggung;
				// if ($scope.data.nomorNPWPTertanggung == '' && !(tryMe.match(/^\d+$/))) {
				// 	//$scope.messages.push({'message':"Nomor NPWP harus benar!"}) ;
				// }
				tryMe = $scope.data.tglLahirPempol;
				if ('' == tryMe) {
					$scope.messages.push({
						'message': "Masukkan tanggal lahir"
					});
				}
				tryMe = $scope.data.tempatLahirPempol;
				if (tryMe == null || tryMe == '') {
					$scope.messages.push({
						'message': "Tempat lahir masih kosong!"
					});
				}
				
				tryMe = $scope.data.jenkelPempol;
				if (tryMe == '0') {
					$scope.messages.push({
						'message': "jenis Kelamin Pempol masih kosong!"
					});
				}

				tryMe = $scope.data.agamaPempol;
				if (tryMe == '0') {
					$scope.messages.push({
						'message': "Agama Pempol masih kosong!"
					});
				}
				
				myRegex = /^[a-zA-Z\s]*$/;
				/*if($scope.data.namaLengkapPempol != ''){
					nama = $scope.data.namaLengkapPempol;
					if(myRegex.test(nama) == false){
						$scope.messages.push({
							'message': "Format Nama Lengkap tidak sesuai! (harus diisi dengan abjad a-z)"
						});
					}
				}*/

				if(!($scope.data.isTertanggungPempol)){
					if($scope.data.imageKTPpempol == null){
						$scope.messages.push({
							'message': "Silahkan swafoto Pemegang Polis dan KTP"
						});
					}
				}


				if($scope.data.tempatLahirPempol != null){
					ttl = $scope.data.tempatLahirPempol;
					if(myRegex.test(ttl) == false){
						$scope.messages.push({
							'message': "Format Tempat lahir tidak sesuai! (harus diisi dengan abjad a-z)"
						});
					}
				}

			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}

			if ($scope.messages.length > 0) {
				return $scope.messages;
			}
			return false;
		}

		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {
				//console.log('Thank you for not eating my delicious ice cream cone');
			});
		};

		// UAT 10 January 2023 Produk Anuitas langsung copy data dari tertanggung

		$scope.moveToNextPage = function () {
			if ($scope.validateThisFormOnPageAccept()) {
				$scope.showAlert('Validasi', spajProvider.alertMessagebuilder($scope.messages));
				$scope.data.isPagePempol1Accepted = false;
				return false;
			} else {
				if ($scope.data.isPagePempol1Accepted) {
					if (confirm('Langsung menuju ke halaman isian form tempat tinggal Pemegang Polis?')) {
						$state.go('aplikasiSPAJOnline.dataPemegangPolis23', {}, {
							reload: true,
							inherit: false
						});
					} else {
						return false;
					}
				}
			}
		}
	}
])
//////////
////////// 
.controller('dataPemegangPolis23Ctrl', ['$state', '$scope', '$stateParams', 'dataFactory', 'spajProvider', '$ionicPopup', 'syncService', '$store',
	function ($state, $scope, $stateParams, dataFactory, spajProvider, $ionicPopup, syncService, $store) {
		$scope.provinsis = dataFactory.getProvinsis();
		$scope.kabupatens = dataFactory.getKabupatens();
		$scope.kabupatens1 = dataFactory.getKabupatens();
		$scope.statustempattinggals = dataFactory.getStatusTempatTinggals();
		$scope.isPageAccepted = function () {
			if (!$scope.data.isPagePempol2Accepted) {
				$scope.showAlert('Apakah data sudah benar?', 'Pastikan Anda yakin data sudah benar untuk melanjutkan kehalaman berikutnya.');
				return false;
			}
		}
		$scope.setKabupatensValues = function (provs) {
			try{
			$scope.kabupatens = dataFactory.getKabupatens();
			kabs = $scope.kabupatens.filter(obj => {
				return (obj.kdprop === '0' || obj.kdprop === provs)
			});
			$scope.kabupatens = kabs;
			$scope.data.kabupatenKTPPempol = '0';
			}catch(e){
				
			}

		}
		$scope.setKabupatensValues1 = function (provs) {
			$scope.kabupatens1 = dataFactory.getKabupatens();
			kabs = $scope.kabupatens1.filter(obj => {
				return (obj.kdprop === '0' || obj.kdprop === provs)
			});
			$scope.kabupatens1 = kabs;
			$scope.data.kabupatenSuratPempol = '0';
			//console.log($scope.kabupatens1 );
		}
		$scope.saveDataSpaj = function () {
			let $formdata = {
				'pageId': 'aplikasiSPAJOnline.dataPemegangPolis23',
				'data': $scope.data
			};
			spajProvider.setSpajGUID($scope.data.spaj_guid);
			$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + $formdata.pageId, $scope.data);
			spajProvider.setSpajElement($formdata);
			//$scope.showAlert('Test Display',angular.toJson(spajProvider.getSpajElement('aplikasiSPAJOnline.dataTertanggung23'), true));
		}
		
		$scope.validateThisFormOnPageAccept = function () {
			$scope.messages = [];
			try {
				if ($scope.data == null) {
					$scope.messages.push({
						"message": "Data ERROR. Null data."
					});
				}
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}

			//validate nama, NOMOR KTP NPWP
			try {
				tryMe = $scope.data.statusTinggalKTPPempol;
				if ($scope.data.statusTinggalKTPPempol == '0') {
					$scope.messages.push({
						'message': "Silahkan pilih status tempat tinggal Pempol!"
					});
				}
				tryMe = $scope.data.alamatKTPPempol;
				if ($scope.data.alamatKTPPempol == '' && !(tryMe.match(/^\d+$/))) {
					$scope.messages.push({
						'message': "Alamat KTP Harus benar!"
					});
				}
				tryMe = $scope.data.provinsiKTPPempol;
				if ($scope.data.provinsiKTPPempol == '0') {
					$scope.messages.push({
						'message': "Provinsi harus dipilih!"
					});
				}
				tryMe = $scope.data.kabupatenKTPPempol;
				if ($scope.data.kabupatenKTPPempol == '0') {
					$scope.messages.push({
						'message': "Kabupaten harus benar!"
					});
				}
				tryMe = $scope.data.kodeposKTPPempol;
				if ($scope.data.kodeposKTPPempol == '') {
					$scope.messages.push({
						'message':"Kodepos harus benar!"
					});
				}

				tryMe = $scope.data.statusTinggalKTPPempol;
				if (tryMe == '0'){
					$scope.messages.push({
						'message':"Status Tinggal KTP Pemegang Polis masih kosong!"
					});
				}
				tryMe = $scope.data.nomorHpPempol;
				if ($scope.data.nomorHpPempol == '' && !(tryMe.match(/^\d+$/))) {
					$scope.messages.push({
						'message': "Nomor HP harus benar!"
					});
				}
				// tryMe = $scope.data.nomorTelpPempol;
				// if (tryMe == '' && !(tryMe.match(/^\d+$/))) {
				// 	$scope.messages.push({
				// 		'message': "Nomor Telepon harus benar!"
				// 	});
				// }
				tryMe = $scope.data.emailPempol;
				if ((typeof $scope.data.emailPempol == '') || !(tryMe.match(/\S+@\S+\.\S+/))) {
					$scope.messages.push({
					'message': "Email harus benar!"
					});
				}


			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}

			if(!($scope.data.isAlamatKTPPempolSama)){
				alamatSuratPempol = $scope.data.alamatSuratPempol;
				if(alamatSuratPempol == ''){
					$scope.messages.push({
						'message':"Alamat surat Pempol harus diisi!"
					});
				}

				provinsiSuratPempol = $scope.data.provinsiSuratPempol;
				if(provinsiSuratPempol == '0'){
					$scope.messages.push({
						'message':"Provinsi surat pempol harus diisi"
					});
				}

				kabupatenSuratPempol = $scope.data.kabupatenSuratPempol;
				if(kabupatenSuratPempol == '0'){
					$scope.messages.push({
						'message':"Kabupaten surat pempol harus diisi"
					});
				}

				tryMe = $scope.data.kodeposSuratPempol;
				if (tryMe == 0) {
					$scope.messages.push({
						'message':"Kodepos harus benar!"
					});
				}

				tryMe = $scope.data.statusTinggalSuratPempol;
				if (tryMe == '0'){
					$scope.messages.push({
						'message':"Status Tinggal Surat Pemegang Polis masih kosong!"
					});
				}
			}

			if ($scope.data.isSetujuHPPempol == false) {
				$scope.messages.push({
					'message': "Silahkan pilih 'YA', untuk setuju di hubungi via HP"
				});
			}

			if ($scope.data.isSetujuEmailPempol == false) {
				$scope.messages.push({
					'message': "Silahkan pilih 'YA', untuk setuju di hubungi via Email"
				});
			}


			if ($scope.messages.length > 0) {
				return $scope.messages;
			}else {
				return false;
			}
		}
		
		$scope.moveToNextPage = function () {
			
			if ($scope.data.isPagePempol2Accepted) {
				
				if ($scope.validateThisFormOnPageAccept()) {
					$scope.data.isPageTertanggung2Accepted = false;
					$scope.showAlert('Validasi', spajProvider.alertMessagebuilder($scope.messages));
					$scope.data.isPagePempol2Accepted = false;
					return false;
				} else {
					
							if (confirm('Langsung menuju ke halaman isian form pendukung Pemegang Polis?')) {
								$state.go('aplikasiSPAJOnline.dataPemegangPolis33', {}, {
									reload: true,
									inherit: false
								});
							} else {
								return false;
							}
				}
				

			}
		}
		prospek = false;
		try {
			$pros = JSON.parse(spajProvider.getProspekData());
			prospek = $pros.find(obj => {
				return obj.build_id === spajProvider.getBuildId()
			});
		} catch (e) {
			prospek = {
				'kdprovinsi': '0',
				'alamat': ''
			}
		}
		
		if ($store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataPemegangPolis23') == null) {
			$scope.data = {
				'spaj_guid': spajProvider.getSpajGUID(),
				'provinsiKTPPempol': prospek.kdpropinsicpp,
				'kabupatenKTPPempol': prospek.kdkotamadyacpp,
				'provinsiSuratPempol': $scope.provinsis[0].id,
				'statusTinggalKTPPempol': $scope.statustempattinggals[0].id,
				'statusTinggalSuratPempol': $scope.statustempattinggals[0].id,
				'alamatKTPPempol': prospek.alamatcpp,
				'kodeposKTPPempol': prospek.kdposcpp,
				'isAlamatKTPPempolSama': false,
				'alamatSuratPempol': '',
				'kabupatenSuratPempol': '',
				'kodeposSuratPempol': '',
				'nomorHpPempol': prospek.hpcpp,
				'nomorTelpPempol': prospek.teleponcpp,
				'emailPempol': prospek.emailcpp,
				'isSetujuHPPempol': false,
				'isSetujuEmailPempol': false,
				'isPagePempol2Accepted': false
			}
		} else {
			$scope.setKabupatensValues(prospek.kdpropinsicpp);
			$scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataPemegangPolis23');
			$scope.setKabupatensValues1($scope.data.provinsiSuratPempol);
			$scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataPemegangPolis23');
		}
		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {
				//console.log('Thank you for not eating my delicious ice cream cone');
			});
		};
	}
])
//////////
//////////
.controller('dataPemegangPolis33Ctrl', ['$scope', '$state', '$stateParams', 'dataFactory', 'spajProvider', '$ionicPopup', '$ionicModal', 'syncService', '$store',
	function ($scope, $state, $stateParams, dataFactory, spajProvider, $ionicPopup, $ionicModal, syncService, $store) {
		$scope.provinsis = dataFactory.getProvinsis();
		$scope.statustempattinggals = dataFactory.getStatusTempatTinggals();
		$scope.pendidikans = dataFactory.getPendidikans();
		$scope.isTertanggungPempol = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataPemegangPolis13').isTertanggungPempol;
		$scope.hubdgntertanggungs = dataFactory.getHubunganDenganPempols();
		//console.log($scope.isTertanggungPempol);
		$scope.moveToNextPage = function () {
			if ($scope.validateThisFormOnPageAccept()) {
				$scope.showAlert('Validasi', spajProvider.alertMessagebuilder($scope.messages));
				$scope.data.isPagePempol3Accepted = false;
				return false;
			} else {
				if ($scope.data.isPagePempol3Accepted) {
					//if (confirm('Langsung menuju ke halaman persetujuan eSPAJ?')) {
						//$state.go('aplikasiSPAJOnline.lembarPersetujuan', {}, {
					if (confirm('Langsung menuju ke halaman pekerjaan pemegang polis?')) {
						$state.go('aplikasiSPAJOnline.pekerjaanPemegangPolis', {}, {
							reload: true,
							inherit: false
						});
					} else {
						return false;
					}
				}
			}
		}
		$scope.isPageAccepted = function () {
			if (!$scope.data.isPagePempol33Accepted) {
				$scope.showAlert('Apakah data sudah benar?', 'Pastikan Anda yakin data sudah benar untuk melanjutkan kehalaman berikutnya.');
				return false;
			}
		}
		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {
				//console.log('Thank you for not eating my delicious ice cream cone');
			});
		};
		$scope.validateThisFormOnPageAccept = function () {
			//validate datanya
			$scope.messages = [];
			try {
				if ($scope.data == null) {
					$scope.messages.push({
						"message": "Data ERROR. Null data."
					});
				}
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			//validate nama, NOMOR KTP NPWP
			try {

				if($scope.data.hubdgnTertanggung == null){
					$scope.messages.push({
						'message': "Silahkan pilih jenis Hubungan dengan Tertanggung Utama !"
					});
				}

				if ($scope.data.tinggiBadanPempol == '') {
					$scope.messages.push({
						'message': "Tinggi badan harus benar! (50cm - 250cm)"
					});
				}

				if ($scope.data.beratBadanPempol == '') {
					$scope.messages.push({
						'message': "Berat badan harus benar! (10kg - 300kg)"
					});
				}
				tryMe = $scope.data.namaIbuPempol;
				if ($scope.data.namaIbuPempol == '' && !(tryMe.match(/^[A-Za-z]+$/))) {
					$scope.messages.push({
						'message': "Nama ibu kandung harus benar! (tidak boleh kosong)"
					});
				}
				tryMe = $scope.data.pendidikanPempol;
				if ('0' == tryMe) {
					$scope.messages.push({
						'message': "Silahkan pilih Pendidikan Terakhir"
					});
				}
				tryMe = $scope.data.statusNikahPempol;
				if ('0' == tryMe) {
					$scope.messages.push({
						'message': "Silahkan pilih Status Pernikahan"
					});
				}

				namaBank = $scope.data.namaBankPemPol;
				if(namaBank == null || namaBank == ''){
					$scope.messages.push({
						'message': "nama Bank Pemegang Polis masih kosong"
					});
				}

				cabangBank = $scope.data.cabangBankPemPol;
				if(cabangBank == null || cabangBank == ''){
					$scope.messages.push({
						'message': "Cabang Bank Pemegang Polis masih kosong"
					});
				}

				noRek = $scope.data.nomorRekeningPemPol;
				if(noRek == null || noRek == ''){
					$scope.messages.push({
						'message': "No Rekening Bank Pemegang Polis masih kosong"
					});
				}

				atasNama = $scope.data.namaRekeningPemPol;
				if(atasNama == null || atasNama == ''){
					$scope.messages.push({
						'message': "Atas Nama Rekening Pemegang Polis masih kosong"
					});
				}
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			if ($scope.messages.length > 0) {
				return $scope.messages;
			}
			return false;
		}
		$scope.statuss = dataFactory.getStatusNikahs();
		$scope.$on('$ionicView.beforeEnter', function (event, viewData) {
			viewData.enableBack = true;
		});
		$scope.saveDataSpaj = function () {
			let $formdata = {
				'pageId': 'aplikasiSPAJOnline.dataPemegangPolis33',
				'data': $scope.data
			};
			spajProvider.setSpajGUID($scope.data.spaj_guid);
			$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + $formdata.pageId, $scope.data);
			spajProvider.setSpajElement($formdata);
			//$scope.showAlert('Test Display',angular.toJson(spajProvider.getSpajElement('aplikasiSPAJOnline.dataPemegangPolis33'), true));
		}
		prospek = false;
		try {
			$pros = JSON.parse(spajProvider.getProspekData());
			prospek = $pros.find(obj => {
				return obj.build_id === spajProvider.getBuildId()
			});
		} catch (e) { }
		
		if ($store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataPemegangPolis33') == null) {
			$scope.data = {
				'spaj_guid': spajProvider.getSpajGUID(),
				'kdproduk': prospek.kd_produk,
				'provinsiSuratTakSerumahPempol': $scope.provinsis[0].id,
				'statusNikahPempol': $scope.statuss[0].id,
				'pendidikanPempol': $scope.pendidikans[0].id,
				'tinggiBadanPempol': '',
				'beratBadanPempol': '',
				'namaIbuPempol': '',
				'namaSaudaraTakSerumahPempol': '',
				'alamatSuratTakSerumahPempol': '',
				'kabupatenTakSerumahPempol': '',
				'kodeposSuratSaudaraTertanggung': '',
				'kodeposTakSerumahPempol': '',
				'noHPTakSerumah': '',
				'noTelTakSerumah': '',
				'isPagePempol3Accepted': false,
				'isTertanggungPempol': false,
			}
		} else {
			$scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataPemegangPolis33');
			$scope.data.kdproduk = prospek.kd_produk;
			console.log($scope.data);
		}
		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {
				//console.log('Thank you for not eating my delicious ice cream cone');
			});
		};
	}
])
//////////
//////////
.controller('pekerjaanTertanggungCtrl', ['$scope', '$state', '$stateParams', 'dataFactory', 'spajProvider', '$ionicPopup', '$store',
	function ($scope, $state, $stateParams, dataFactory, spajProvider, $ionicPopup, $store) {
		$scope.pekerjaans = dataFactory.getPekerjaans();
		$scope.pangkats = dataFactory.getPangkats();
		$scope.kelaspekerjaans = dataFactory.getKelasPekerjaans();
		$scope.jenisperusahaans = dataFactory.getJenisPerusahaans();
		$scope.rangegajitertanggungs = dataFactory.getRangeGajis();
		$scope.jenisPendapatans = dataFactory.getJenisPendapatans();
		$scope.messages = false;
		$scope.pageId = 'aplikasiSPAJOnline.pekerjaanTertanggung';
		//INIT FORM 
		$scope.$on('$ionicView.enter', function () {
			$scope.init_data();
			$scope.init_display();
		});
		$scope.init_display = function () {
			return true;
		};
		prospek = false;
		try {
			$pros = JSON.parse(spajProvider.getProspekData());
			prospek = $pros.find(obj => {
				return obj.build_id === spajProvider.getBuildId()
			});
		} catch (e) {}
		//console.log('disini bang')
		
		$scope.init_data = function () {
			$scope.data = {
				'spaj_guid': spajProvider.getSpajGUID(),
				'jenisPerusahaanTertanggung': $scope.jenisperusahaans[0].id,
				'pekerjaanTertanggung': prospek.kdpekerjaanctt,
				'pangkatTertanggung': $scope.pangkats[0].id,
				'klasifikasiPekerjaanTertanggung': '',
				'jenisPendapatan' : $scope.jenisPendapatans[0].id,
				'rangeGajiTertanggung': $scope.rangegajitertanggungs[2].id,
				'rangePendapatanTertanggung': $scope.rangegajitertanggungs[2].id,
				'rangePendapatanPasangan': $scope.rangegajitertanggungs[2].id,
				'rangeHasilInvestasi': $scope.rangegajitertanggungs[2].id,
				'rangeBisnis': $scope.rangegajitertanggungs[2].id,
				'rangeBonus': $scope.rangegajitertanggungs[2].id,
				'rangePendapatanOrangTua' : $scope.rangegajitertanggungs[2].id,
				'rangePendapatanTertanggung': $scope.rangegajitertanggungs[2].id,
				'sumberPendapatanLainnya': '',
				'namaPerusahaanTertanggung': '',
				'alamatPerusahaanTertanggung': '',
				'kodeposPerusahaanTertanggung': '',
				'nomorTeleponPerusahaanTertanggung': '',
				'nomorEkstensiPerusahaanTertanggung': '',
				'isPagePekerjaanTertanggung1Accepted': '',
				'pemilikWirausahaTertanggung': '',
				'bidangWirausahaTertanggung': '',
				'namaWirausahaTertanggung': '',
				'alamatWirausahaTertanggung': '',
				'rangeGajiTertanggungJmlLainnya' : '',
				'rangePendapatanPasanganLainnya' : '',
				'usiaProduktifPasangan' : '',
				'usiaProduktifOrangTua' : '',
				'rangeHasilInvestasiLainnya' : '',
				'rangeBisnisLainnya' : '',
				'rangeBonusLainnya' : '',
				'rangePendapatanOrangTuaLainnya' : '',
				'rangePendapatanTertanggungLainnya': '',
				'penghasilanTertanggung': prospek.penghasilan
			}
			if ($store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + $scope.pageId) == null) {} else {
				$scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + $scope.pageId);
			}
		}

		$scope.tertanggungAdalahWiraswasta = function (val) {
			if(val){
				$scope.data.jenisPerusahaanTertanggung =  $scope.jenisperusahaans[7].id;
				$scope.data.namaPerusahaanTertanggung = '-';
				$scope.data.alamatPerusahaanTertanggung = '-';
				$scope.data.kodeposPerusahaanTertanggung = '-';
				$scope.data.nomorTeleponPerusahaanTertanggung = '-';
				$scope.data.nomorEkstensiPerusahaanTertanggung = '-';
			}else{
				$scope.data.jenisPerusahaanTertanggung =  $scope.jenisperusahaans[0].id;
				$scope.data.namaPerusahaanTertanggung = '';
				$scope.data.alamatPerusahaanTertanggung = '';
				$scope.data.kodeposPerusahaanTertanggung = '';
				$scope.data.nomorTeleponPerusahaanTertanggung = '';
				$scope.data.nomorEkstensiPerusahaanTertanggung = '';
			}
			
		}
		
		$scope.validateThisFormOnPageAccept = function () {
			console.log($scope.data);
			//validate datanya
			$scope.messages = [];
			try {
				if ($scope.data == null) {
					$scope.messages.push({
						"message": "Data ERROR. Null data."
					});
				}
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			//validate nama, NOMOR KTP NPWP
			try {

				tryMe = $scope.data.pangkatTertanggung;
				if ($scope.data.pangkatTertanggung == '0') {
					$scope.messages.push({
						'message':"Pangkat/jabatan/golongan harus benar!"
					}) ;
				}

				tryMe = $scope.data.jenisPendapatan
				if(tryMe == '0'){
					$scope.messages.push({
						'message':"Silahkan pilih jenis pendapatan!"
					}) ;
				}

				tryMe = $scope.data.rangeGajiTertanggung
				if(tryMe == '10sd50'){
					if($scope.data.rangeGajiTertanggungJmlLainnya == '' || $scope.data.rangeGajiTertanggungJmlLainnya == null){
						$scope.messages.push({
							'message':"Silahkan masukkan range Gaji!"
						}) ;
					}
				}

				tryMe = $scope.data.rangePendapatanPasangan
				if(tryMe == '10sd50'){
					if($scope.data.rangePendapatanPasanganLainnya == '' || $scope.data.rangePendapatanPasanganLainnya == null){
						$scope.messages.push({
							'message':"Silahkan masukkan range pendapatan suami/istri!"
						}) ;
					}

					if($scope.data.usiaProduktifPasangan == '' || $scope.data.usiaProduktifPasangan == null){
						$scope.messages.push({
							'message':"Silahkan masukkan usia produktif suami/istri!"
						}) ;	
					}
				}

				tryMe = $scope.data.rangeHasilInvestasi
				if(tryMe == '10sd50'){
					if($scope.data.rangeHasilInvestasiLainnya == '' || $scope.data.rangeHasilInvestasiLainnya == null){
						$scope.messages.push({
							'message':"Silahkan masukkan range Hasil Investasi!"
						}) ;
					}
				}

				tryMe = $scope.data.rangeBisnis
				if(tryMe == '10sd50'){
					if($scope.data.rangeBisnisLainnya == '' || $scope.data.rangeBisnisLainnya == null){
						$scope.messages.push({
							'message':"Silahkan masukkan range Bisnis!"
						}) ;
					}
				}

				tryMe = $scope.data.rangeBonus
				if(tryMe == '10sd50'){
					if($scope.data.rangeBonusLainnya == '' || $scope.data.rangeBonusLainnya == null){
						$scope.messages.push({
							'message':"Silahkan masukkan range Bonus!"
						}) ;
					}
				}

				tryMe = $scope.data.rangePendapatanOrangTua
				if(tryMe == '10sd50'){
					if($scope.data.rangePendapatanOrangTuaLainnya == '' || $scope.data.rangePendapatanOrangTuaLainnya == null){
						$scope.messages.push({
							'message':"Silahkan masukkan range Pendapatan Orang Tua!"
						}) ;
					}

					if($scope.data.usiaProduktifOrangTua == '' || $scope.data.usiaProduktifOrangTua == null){
						$scope.messages.push({
							'message':"Silahkan Usia Produktif Orang Tua!"
						}) ;
					}
				}

				tryMe = $scope.data.rangePendapatanTertanggung
				if(tryMe == '10sd50'){
					if($scope.data.rangePendapatanTertanggungLainnya == '' || $scope.data.rangePendapatanTertanggungLainnya == null){
						$scope.messages.push({
							'message':"Silahkan masukkan Range pendapatan Lainnya!"
						}) ;
					}

					if($scope.data.sumberPendapatanLainnya == '' || $scope.data.sumberPendapatanLainnya == null){
						$scope.messages.push({
							'message':"Silahkan masukkan Asal sumber pendapatan!"
						}) ;
					}
				}


				tryMe = $scope.data.pekerjaanTertanggung;
				if (tryMe == 'wirausaha') {
					if(''==$scope.data.pemilikWirausahaTertanggung) $scope.messages.push({'message':"Kepemilikan usaha harus benar!"});
					if(''==$scope.data.bidangWirausahaTertanggung)$scope.messages.push({'message':"Bidang wirausaha harus benar!"});
					if(''==$scope.data.namaWirausahaTertanggung)$scope.messages.push({'message':"Nama wirausaha harus benar!"});
					if(''==$scope.data.alamatWirausahaTertanggung)$scope.messages.push({'message':"Alamat wirausaha harus benar!"});
				}else{
					tryMe = $scope.data.jenisPerusahaanTertanggung;
					if (tryMe == '0') {
						$scope.messages.push({
							'message': "Silahkan isi jenis perusahaan!"
						});
					}
					tryMe = $scope.data.namaPerusahaanTertanggung;
					if (tryMe == '') {
						$scope.messages.push({
							'message': "Nama Perusahaan harus benar!"
						});
					}
					tryMe = $scope.data.alamatPerusahaanTertanggung;
					if(tryMe == ''){
						$scope.messages.push({
							'message': "Silahkan isi Alamat perusahaan"
						});
					}
					tryMe = $scope.data.kodeposPerusahaanTertanggung;
					if (tryMe == ''){
						$scope.messages.push({
							'message': "Kode Pos Perusahaan harus benar!"
						});
					}
					tryMe = $scope.data.nomorTeleponPerusahaanTertanggung;
					if (tryMe == ''){
						$scope.messages.push({
							'message': "nomor Telepon Perusahaan harus benar!"
						});
					}
					tryMe = $scope.data.nomorEkstensiPerusahaanTertanggung;
					if(tryMe == ''){
						$scope.messages.push({
							'message': "nomor Eksistensi Perusahaan harus benar!"
						});
					}
	
				}

				/** Jika dia wirausaha */
				// if($scope.data.pemilikWirausahaTertanggung == ''){
				// 	tryMe = $scope.data.jenisPerusahaanTertanggung;
				// 	if (tryMe == '0') {
				// 		$scope.messages.push({
				// 			'message': "Silahkan isi jenis perusahaan!"
				// 		});
				// 	}
				// 	tryMe = $scope.data.namaPerusahaanTertanggung;
				// 	if (tryMe == '') {
				// 		$scope.messages.push({
				// 			'message': "Nama Perusahaan harus benar!"
				// 		});
				// 	}
				// 	tryMe = $scope.data.kodeposPerusahaanTertanggung;
				// 	if (tryMe == ''){
				// 		$scope.messages.push({
				// 			'message': "Silahkan isi Kode Pos perusahaan"
				// 		});
				// 	}
				// 	tryMe = $scope.data.alamatPerusahaanTertanggung;
				// 	if(tryMe == ''){
				// 		$scope.messages.push({
				// 			'message': "Silahkan isi Alamat perusahaan"
				// 		});
				// 	}
				// 	tryMe = $scope.data.kodeposPerusahaanTertanggung;
				// 	if (tryMe == ''){
				// 		$scope.messages.push({
				// 			'message': "Kode Pos Perusahaan harus benar!"
				// 		});
				// 	}
				// 	tryMe = $scope.data.nomorTeleponPerusahaanTertanggung;
				// 	if (tryMe == ''){
				// 		$scope.messages.push({
				// 			'message': "nomor Telepon Perusahaan harus benar!"
				// 		});
				// 	}
				// 	tryMe = $scope.data.nomorEkstensiPerusahaanTertanggung;
				// 	if(tryMe == ''){
				// 		$scope.messages.push({
				// 			'message': "nomor Eksistensi Perusahaan harus benar!"
				// 		});
				// 	}
				// }else{
				// 	if(''==$scope.data.pemilikWirausahaTertanggung) $scope.messages.push({'message':"Kepemilikan usaha harus benar!"});
				// 	if(''==$scope.data.bidangWirausahaTertanggung)$scope.messages.push({'message':"Bidang wirausaha harus benar!"});
				// 	if(''==$scope.data.namaWirausahaTertanggung)$scope.messages.push({'message':"Nama wirausaha harus benar!"});
				// 	if(''==$scope.data.alamatWirausahaTertanggung)$scope.messages.push({'message':"Alamat wirausaha harus benar!"});
				// }
				/** End */
				
				tryMe = $scope.data.rangeGajiTertanggung;
				if ($scope.data.rangeGajiTertanggung == '0') {
					//$scope.messages.push({'message':"Range Gaji harus benar!"}) ;
				}
				tryMe = $scope.data.rangePendapatanPasangan;
				if ('0' == tryMe) {
					//$scope.messages.push({'message':"Range pendapatan suami/istri harus benar!"});
				}
				tryMe = $scope.data.rangeHasilInvestasi;
				if ('0' == tryMe) {
					//$scope.messages.push({'message':"Range hasil investasi harus benar!"});
				}
				tryMe = $scope.data.rangeBisnis;
				if ('0' == tryMe) {
					//$scope.messages.push({'message':"Range hasil bisnis pribadi harus benar!"});
				}
				tryMe = $scope.data.rangePendapatanTertanggung;
				if ('0' == tryMe) {
					//$scope.messages.push({'message':"Range pendapatan lainnya harus benar!"});
				}
				if ('4' == tryMe) {
					//if($scope.data.rangePendapatanTertanggungLainnya=='') $scope.messages.push({'message':"Jumlah pendapatan lainnya harus benar!"});
					//if($scope.data.sumberPendapatanLainnya=='') $scope.messages.push({'message':"Sumber pendapatan lainnya harus benar!"});
				}
				tryMe = $scope.data.jenisPerusahaanTertanggung;
				if (tryMe == '0') {
					// $scope.messages.push({
					// 	'message':"Jenis perusahaan harus benar!"
					// });
				}
				tryMe = $scope.data.jenisPerusahaanTertanggung;
				if ('0' == tryMe) {
					//$scope.messages.push({'message':"Jenis perusahaan harus benar!"});
				}
				tryMe = $scope.data.namaPerusahaanTertanggung;
				if ('' == tryMe) {
					//$scope.messages.push({'message':"Nama perusahaan harus benar!"});
				}
				tryMe = $scope.data.alamatPerusahaanTertanggung;
				if ('' == tryMe) {
					//$scope.messages.push({'message':"Alamat perusahaan harus benar!"});
				}
				tryMe = $scope.data.kodeposPerusahaanTertanggung;
				if ('' == tryMe) {
					//$scope.messages.push({'message':"Kodepos perusahaan harus benar!"});
				}
				tryMe = $scope.data.nomorTeleponPerusahaanTertanggung;
				if ('' == tryMe) {
					//$scope.messages.push({'message':"Nomor telpon perusahaan harus benar!"});
				}
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			if ($scope.messages.length > 0) {
				return $scope.messages;
			}
			return false;
		}
		$scope.selectJenisPendapatans = function (idJenisPendapatan){
			if(idJenisPendapatan == 1){
				$scope.data.rangeGajiTertanggung = $scope.rangegajitertanggungs[1].id;
				$scope.data.rangeGajiTertanggungJmlLainnya = prospek.penghasilan;
			}else{
				$scope.data.rangeGajiTertanggung = $scope.rangegajitertanggungs[2].id;
				$scope.data.rangeGajiTertanggungJmlLainnya = '';
			}

			if(idJenisPendapatan == 2){
				$scope.data.rangePendapatanPasangan = $scope.rangegajitertanggungs[1].id;
				$scope.data.rangePendapatanPasanganLainnya = prospek.penghasilan;
			}else{
				$scope.data.rangePendapatanPasangan = $scope.rangegajitertanggungs[2].id;
				$scope.data.rangePendapatanPasanganLainnya = '';
			}

			if(idJenisPendapatan == 3){
				$scope.data.rangeHasilInvestasi = $scope.rangegajitertanggungs[1].id;
				$scope.data.rangeHasilInvestasiLainnya = prospek.penghasilan;
			}else{
				$scope.data.rangeHasilInvestasi = $scope.rangegajitertanggungs[2].id;
				$scope.data.rangeHasilInvestasiLainnya = '';
			}

			if(idJenisPendapatan == 4){
				$scope.data.rangeBisnis = $scope.rangegajitertanggungs[1].id;
				$scope.data.rangeBisnisLainnya = prospek.penghasilan;
			}else{
				$scope.data.rangeBisnis = $scope.rangegajitertanggungs[2].id;
				$scope.data.rangeBisnisLainnya = '';
			}

			if(idJenisPendapatan == 5){
				$scope.data.rangeBonus = $scope.rangegajitertanggungs[1].id;
				$scope.data.rangeBonusLainnya = prospek.penghasilan;
			}else{
				$scope.data.rangeBonus = $scope.rangegajitertanggungs[2].id;
				$scope.data.rangeBonusLainnya = '';
			}

			if(idJenisPendapatan == 6){
				$scope.data.rangePendapatanOrangTua = $scope.rangegajitertanggungs[1].id;
				$scope.data.rangePendapatanOrangTuaLainnya = prospek.penghasilan;
			}else{
				$scope.data.rangePendapatanOrangTua = $scope.rangegajitertanggungs[2].id;
				$scope.data.rangePendapatanOrangTuaLainnya = '';
			}

			if(idJenisPendapatan == 7){
				$scope.data.rangePendapatanTertanggung = $scope.rangegajitertanggungs[1].id;
				$scope.data.rangePendapatanTertanggungLainnya = prospek.penghasilan;
			}else{
				$scope.data.rangePendapatanTertanggung = $scope.rangegajitertanggungs[2].id;
				$scope.data.rangePendapatanTertanggungLainnya = '';
			}
		}

		$scope.saveDataSpaj = function () {
			let $formdata = {
				'pageId': $scope.pageId,
				'data': $scope.data
			};
			spajProvider.setSpajGUID($scope.data.spaj_guid);
			$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + $formdata.pageId, $scope.data);
			spajProvider.setSpajElement($formdata);
			//$scope.showAlert('Test Display',angular.toJson(spajProvider.getSpajElement('aplikasiSPAJOnline.pekerjaanTertanggung'), true));
		}

		$scope.getKelasPekerjaan = function (idpekerjaan) {
			let dtpek = null;
			for (i = 1; i < $scope.pekerjaans.length; i++) {
				if (idpekerjaan == $scope.pekerjaans[i].id) {
					dtpek = $scope.pekerjaans[i].kelas;
				}
			}
			$scope.data.klasifikasiPekerjaanTertanggung = dtpek;
			return dtpek;
		}
		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {
				//console.log('Thank you for not eating my delicious ice cream cone');
			});
		};
		$scope.moveToNextPage = function () {
			if ($scope.validateThisFormOnPageAccept()) {
				$scope.showAlert('Validasi', spajProvider.alertMessagebuilder($scope.messages));
				$scope.data.isPagePekerjaanTertanggung1Accepted = false;
			} else {
				if ($scope.data.isPagePekerjaanTertanggung1Accepted) {
					if (confirm('Langsung menuju ke halaman form isian Produk dan Penerima Manfaat?')) {
						$state.go('aplikasiSPAJOnline.produkDanManfaat12', {}, {
							reload: false,
							inherit: false
						});
					} else {
						return false;
					}
				}
			}
		}
	}
])
//////////
//////////
.controller('pekerjaanPemegangPolisCtrl', ['$scope', '$state', '$stateParams', 'dataFactory', 'spajProvider', '$ionicPopup', '$store',
	function ($scope, $state, $stateParams, dataFactory, spajProvider, $ionicPopup, $store) {
		$scope.pekerjaans = dataFactory.getPekerjaans();
		$scope.pangkats = dataFactory.getPangkats();
		$scope.kelaspekerjaans = dataFactory.getKelasPekerjaans();
		$scope.rangegajiPempols = dataFactory.getRangeGajis();
		$scope.jenisperusahaans = dataFactory.getJenisPerusahaans();
		$scope.jenisPendapatans = dataFactory.getJenisPendapatans();
		$scope.alasanWajibPajakLuarNegeris = [
			{'id': 0,'label': '--PILIH--'}
		   ,{'id': 1,'label': 'ADA'}
		   ,{'id': 2,'label': 'TIDAK ADA'}
	   ];
		$scope.getKelasPekerjaan = function (idpekerjaan) {
			let dtpek = null;
			for (i = 1; i < $scope.pekerjaans.length; i++) {
				if (idpekerjaan == $scope.pekerjaans[i].id) {
					dtpek = $scope.pekerjaans[i].kelas;
				}
			}
			$scope.data.klasifikasiPekerjaanPempol = dtpek;
			return dtpek;
		}

		$scope.$on('$ionicView.beforeEnter', function (event, viewData) {
			viewData.enableBack = true;
		});

		$scope.validateThisFormOnPageAccept = function () {
			//validate datanya
			$scope.messages = [];
			try {
				if ($scope.data == null) {
					$scope.messages.push({
						"message": "Data ERROR. Null data."
					});
				}
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			//validate nama, NOMOR KTP NPWP
			try {

				tryMe = $scope.data.pangkatPempol;
				if ($scope.data.pangkatPempol == '0') {
					$scope.messages.push({'message':"Pangkat/jabatan/golongan harus benar!"}) ;
				}

				if($scope.data.jenisPendapatanPempol == '0'){
					$scope.messages.push({
						'message': "Silahkan Pilih jenis pendapatan pemegang polis"
					});
				}

				// Jika Penghasilan tidak diisi
				// if($scope.data.rangeGajiPempol == '0' || $scope.data.rangePendapatanPasanganPempol == '0' || $scope.data.rangeHasilInvestasiPempol == '0' || $scope.data.rangeBisnisPempol == '0' || $scope.data.rangeBonusPempol == '0' || $scope.data.rangePendapatanPempol == '0'){
				// 	$scope.messages.push({
				// 		'message': "Silahkan Pilih, minimal salah satu jenis pendapatan pemegang polis"
				// 	});
				// }

				// Jika Range Gaji Pempol, ADA tapi Range Gaji tidak diisi 
				if($scope.data.rangeGajiPempol != '0'){
					if($scope.data.rangeGajiPempolJmlLainnya == '' || $scope.data.rangeGajiPempolJmlLainnya == 0 || $scope.data.rangeGajiPempolJmlLainnya == null){
						$scope.messages.push({
							'message': "Range Gaji pemegang polis harus diisi!"
						});
					}
				}

				// Jika Range Pendapatan Pasangan, ADA tapi Range pendapatan pasangan tidak diisi 			
				if($scope.data.rangePendapatanPasanganPempol != '0'){
					if($scope.data.rangePendapatanPasanganPempolLainnya == '' || $scope.data.rangePendapatanPasanganPempolLainnya == 0 || $scope.data.rangePendapatanPasanganPempolLainnya == null){
						$scope.messages.push({
							'message': "Range Pendapatan Suami/Istri pemegang polis harus diisi!"
						});
					}

					if($scope.data.usiaProduktifPasanganPempol == '' || $scope.data.usiaProduktifPasanganPempol == null){
						$scope.messages.push({
							'message': "Usia Produktif Suami/Istri pemegang polis harus diisi!"
						});
					}
				}

				// Jika Range Hasil Investasi, ADA tapi Range hasil investasi tidak diisi 	
				if($scope.data.rangeHasilInvestasiPempol != '0'){
					if($scope.data.rangeHasilInvestasiPempolLainnya == '' || $scope.data.rangeHasilInvestasiPempolLainnya == null || $scope.data.rangeHasilInvestasiPempolLainnya == 0){
						$scope.messages.push({
							'message': "Range Hasil Investasi pemegang polis harus diisi!"
						});
					}
				}

				// Jika Range Bisnis , ADA tapi Range bisnis lainnya tidak diisi 		
				if($scope.data.rangeBisnisPempol != '0'){
					if($scope.data.rangeBisnisPempolLainnya == '' || $scope.data.rangeBisnisPempolLainnya == 0 || $scope.data.rangeBisnisPempolLainnya == null){
						$scope.messages.push({
							'message': "Range Bisnis pemegang polis Lainnya harus diisi!"
						});
					}
				}


				// Jika Range Bonus , ADA tapi Range Bonus lainnya tidak diisi 	
				if($scope.data.rangeBonusPempol != '0'){
					if($scope.data.rangeBonusPempolLainnya == '' || $scope.data.rangeBonusPempolLainnya == 0 || $scope.data.rangeBonusPempolLainnya == null){
						$scope.messages.push({
							'message': "Range Bonus pemegang polis Lainnya harus diisi!"
						});
					}
				}

				// Range pendapatan orang tua
				if($scope.data.rangePendapatanOrangTuaPempol != '0'){
					if($scope.data.rangePendapatanOrangTuaPempolLainnya == '' || $scope.data.rangePendapatanOrangTuaPempolLainnya == null || $scope.data.rangePendapatanOrangTuaPempolLainnya == 0){
						$scope.messages.push({
							'message': "Range Pendapatan Orang tua pemegang polis harus diisi!"
						});
					}

					if($scope.data.usiaProduktifOrangTuaPempol == '' || $scope.data.usiaProduktifOrangTuaPempol == null){
						$scope.messages.push({
							'message': "Usia Produktif Orang tua pemegang polis harus diisi!"
						});
					}
				}

				// Jika Pendapatn Lain Pempol, ADA tapi Range Pendapatan Pempol lainnya tidak diisi 	
				if($scope.data.rangePendapatanPempol != '0'){
					if($scope.data.rangePendapatanPempolLainnya == '' || $scope.data.rangePendapatanPempolLainnya == null || $scope.data.rangePendapatanPempolLainnya == 0){
						$scope.messages.push({
							'message': "Range Pendapatan Lainnya pemegang polis harus diisi!"
						});
					}

					if($scope.data.sumberPendapatanPempolLainnya == '' || $scope.data.sumberPendapatanPempolLainnya){
						$scope.messages.push({
							'message': "Sumber Pendapatan Lainnya pemegang polis harus diisi!"
						});
					}
				}


				tryMe = $scope.data.pekerjaanPempol;
				if (tryMe == 'wirausaha') {
					if(''==$scope.data.pemilikWirausahaPempol) $scope.messages.push({'message':"Kepemilikan usaha harus benar!"});
					if(''==$scope.data.bidangWirausahaPempol)$scope.messages.push({'message':"Bidang wirausaha harus benar!"});
					if(''==$scope.data.namaWirausahaPempol)$scope.messages.push({'message':"Nama wirausaha harus benar!"});
					if(''==$scope.data.alamatWirausahaPempol)$scope.messages.push({'message':"Alamat wirausaha harus benar!"});
				} else{
					tryMe = $scope.data.jenisPerusahaanPempol;
					if (tryMe == '0') {
						$scope.messages.push({
							'message': "Silahkan isi jenis perusahaan!"
						});
					}
					tryMe = $scope.data.namaPerusahaanPempol;
					if (tryMe == '') {
						$scope.messages.push({
							'message': "Nama Perusahaan harus benar!"
						});
					}
					tryMe = $scope.data.alamatPerusahaanPempol;
					if (tryMe == '') {
						$scope.messages.push({
							'message': "Alamat Perusahaan harus benar!"
						});
					}
					tryMe = $scope.data.kodeposPerusahaanPempol;
					if (tryMe == ''){
						$scope.messages.push({
							'message': "Kode Pos Perusahaan harus benar!"
						});
					}
					tryMe = $scope.data.nomorTeleponPerusahaanPempol;
					if (tryMe == ''){
						$scope.messages.push({
							'message': "nomor Telepon Perusahaan harus benar!"
						});
					}
					tryMe = $scope.data.nomorEkstensiPerusahaanPempol;
					if (tryMe == ''){
						$scope.messages.push({
							'message': "nomor Eksistensi Perusahaan harus benar!"
						});
					}

				}

				if($scope.data.wajibPajakLuarNegeri){
					negaraPajak = $scope.data.negaraWajibPajakLuarNegeri
					if(negaraPajak == null || negaraPajak == ''){
						$scope.messages.push({
							'message': "Nama negara wajib pajak luar negeri, masih kosong!"
						});
					}
				}
	
				


				// tryMe = $scope.data.rangeGajiPempol;
				// if ($scope.data.rangeGajiPempol == '0') {
				// 	//$scope.messages.push({'message':"Range Gaji harus benar!"}) ;
				// }
				// tryMe = $scope.data.rangePendapatanPasangan;
				// if ('0' == tryMe) {
				// 	//$scope.messages.push({'message':"Range pendapatan suami/istri harus benar!"});
				// }
				// tryMe = $scope.data.rangeHasilInvestasi;
				// if ('0' == tryMe) {
				// 	//$scope.messages.push({'message':"Range hasil investasi harus benar!"});
				// }
				// tryMe = $scope.data.rangeBisnis;
				// if ('0' == tryMe) {
				// 	//$scope.messages.push({'message':"Range hasil bisnis pribadi harus benar!"});
				// }
				// tryMe = $scope.data.rangePendapatanPempol;
				// if ('0' == tryMe) {
				// 	//$scope.messages.push({'message':"Range pendapatan lainnya harus benar!"});
				// }
				// if ('4' == tryMe) {
				// 	//if($scope.data.rangePendapatanTertanggungLainnya=='') $scope.messages.push({'message':"Jumlah pendapatan lainnya harus benar!"});
				// 	//if($scope.data.sumberPendapatanLainnya=='') $scope.messages.push({'message':"Sumber pendapatan lainnya harus benar!"});
				// }
				// tryMe = $scope.data.jenisPerusahaanTertanggung;
				// if (tryMe == '0') {
				// 	// $scope.messages.push({
				// 	// 	'message':"Jenis perusahaan harus benar!"
				// 	// });
				// }
				// tryMe = $scope.data.jenisPerusahaanTertanggung;
				// if ('0' == tryMe) {
				// 	//$scope.messages.push({'message':"Jenis perusahaan harus benar!"});
				// }
				// tryMe = $scope.data.namaPerusahaanTertanggung;
				// if ('' == tryMe) {
				// 	//$scope.messages.push({'message':"Nama perusahaan harus benar!"});
				// }
				// tryMe = $scope.data.alamatPerusahaanTertanggung;
				// if ('' == tryMe) {
				// 	//$scope.messages.push({'message':"Alamat perusahaan harus benar!"});
				// }
				// tryMe = $scope.data.kodeposPerusahaanTertanggung;
				// if ('' == tryMe) {
				// 	//$scope.messages.push({'message':"Kodepos perusahaan harus benar!"});
				// }
				// tryMe = $scope.data.nomorTeleponPerusahaanTertanggung;
				// if ('' == tryMe) {
				// 	//$scope.messages.push({'message':"Nomor telpon perusahaan harus benar!"});
				// }
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			if ($scope.messages.length > 0) {
				return $scope.messages;
			}
			return false;
		}

		$scope.pempolAdalahWiraswasta = function (val) {
			if(val){
				$scope.data.jenisPerusahaanPempol =  $scope.jenisperusahaans[7].id;
				$scope.data.namaPerusahaanPempol = '-';
				$scope.data.alamatPerusahaanPempol = '-';
				$scope.data.kodeposPerusahaanPempol = '-';
				$scope.data.nomorTeleponPerusahaanPempol = '-';
				$scope.data.nomorEkstensiPerusahaanPempol = '-';
			}else{
				$scope.data.jenisPerusahaanPempol =  $scope.jenisperusahaans[0].id;
				$scope.data.namaPerusahaanPempol = '';
				$scope.data.alamatPerusahaanPempol = '';
				$scope.data.kodeposPerusahaanPempol = '';
				$scope.data.nomorTeleponPerusahaanPempol = '';
				$scope.data.nomorEkstensiPerusahaanPempol = '';
			}
			
		}

		$scope.selectJenisPendapatanPempols = function (idJenisPendapatan){
			if($scope.data.penghasilanPempol != 0){
				penghasilan = prospek.penghasilan;
			}else{
				penghasilan = 0;
			}

			if(idJenisPendapatan == 1){
				$scope.data.rangeGajiPempol = $scope.rangegajiPempols[1].id;
				$scope.data.rangeGajiPempolJmlLainnya = penghasilan;
			}else{
				$scope.data.rangeGajiPempol = $scope.rangegajiPempols[2].id;
				$scope.data.rangeGajiPempolJmlLainnya = '';
			}

			if(idJenisPendapatan == 2){
				$scope.data.rangePendapatanPasanganPempol = $scope.rangegajiPempols[1].id;
				$scope.data.rangePendapatanPasanganPempolLainnya = penghasilan;
			}else{
				$scope.data.rangePendapatanPasanganPempol = $scope.rangegajiPempols[2].id;
				$scope.data.rangePendapatanPasanganPempolLainnya = '';
			}

			if(idJenisPendapatan == 3){
				$scope.data.rangeHasilInvestasiPempol = $scope.rangegajiPempols[1].id;
				$scope.data.rangeHasilInvestasiPempolLainnya = penghasilan;
			}else{
				$scope.data.rangeHasilInvestasiPempol = $scope.rangegajiPempols[2].id;
				$scope.data.rangeHasilInvestasiPempolLainnya = '';
			}

			if(idJenisPendapatan == 4){
				$scope.data.rangeBisnisPempol = $scope.rangegajiPempols[1].id;
				$scope.data.rangeBisnisPempolLainnya = penghasilan;
			}else{
				$scope.data.rangeBisnisPempol = $scope.rangegajiPempols[2].id;
				$scope.data.rangeBisnisPempolLainnya = '';
			}

			if(idJenisPendapatan == 5){
				$scope.data.rangeBonusPempol = $scope.rangegajiPempols[1].id;
				$scope.data.rangeBonusPempolLainnya = penghasilan;
			}else{
				$scope.data.rangeBonusPempol = $scope.rangegajiPempols[2].id;
				$scope.data.rangeBonusPempolLainnya = '';
			}

			if(idJenisPendapatan == 6){
				$scope.data.rangePendapatanOrangTuaPempol = $scope.rangegajiPempols[1].id;
				$scope.data.rangePendapatanOrangTuaPempolLainnya = penghasilan;
			}else{
				$scope.data.rangePendapatanOrangTuaPempol = $scope.rangegajiPempols[2].id;
				$scope.data.rangePendapatanOrangTuaPempolLainnya = '';
			}

			if(idJenisPendapatan == 7){
				$scope.data.rangePendapatanPempol = $scope.rangegajiPempols[1].id;
				$scope.data.rangePendapatanPempolLainnya = penghasilan;
			}else{
				$scope.data.rangePendapatanPempol = $scope.rangegajiPempols[2].id;
				$scope.data.rangePendapatanPempolLainnya = '';
			}
		}

		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {
				//console.log('Thank you for not eating my delicious ice cream cone');
			});
		};

		$scope.saveDataSpaj = function () {
			let $formdata = {
				'pageId': 'aplikasiSPAJOnline.pekerjaanPemegangPolis',
				'data': $scope.data
			};
			spajProvider.setSpajGUID($scope.data.spaj_guid);
			$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + $formdata.pageId, $scope.data);
			spajProvider.setSpajElement($formdata);
			//$scope.showAlert('Test Display',angular.toJson(spajProvider.getSpajElement('aplikasiSPAJOnline.pekerjaanPemegangPolis'), true));
		}

		$scope.moveToNextPage = function () {
			if ($scope.validateThisFormOnPageAccept()) {
				$scope.showAlert('Validasi', spajProvider.alertMessagebuilder($scope.messages));
				$scope.data.isPagePekerjaanPempol1Accepted = false;
			} else {
				if ($scope.data.isPagePekerjaanPempol1Accepted) {
					if (confirm('Langsung menuju ke halaman persetujuan eSPAJ?')) {
						$state.go('aplikasiSPAJOnline.lembarPersetujuan', {}, {
							reload: true,
							inherit: false
						});
					} else {
						return false;
					}
				}
			}
		}

		prospek = false;
		try {
			$pros = JSON.parse(spajProvider.getProspekData());
			prospek = $pros.find(obj => {
				return obj.build_id === spajProvider.getBuildId()
			});
		} catch (e) {}
		if ($store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.pekerjaanPemegangPolis') == null) {
			$scope.data = {
				'spaj_guid': spajProvider.getSpajGUID(),
				'jenisPerusahaanPempol': $scope.jenisperusahaans[0].id,
				'pekerjaanPempol': prospek.kdpekerjaancpp,
				'pangkatPempol': $scope.pangkats[0].id,
				'klasifikasiPekerjaanPempol': $scope.kelaspekerjaans[0].id,
				'jenisPendapatanPempol' : $scope.jenisPendapatans[0].id,
				'penghasilanPempol' : 0,
				'rangeGajiPempol': $scope.rangegajiPempols[0].id,
				'rangePendapatanPempol': $scope.rangegajiPempols[0].id,
				'rangePendapatanPasanganPempol': $scope.rangegajiPempols[0].id,
				'rangePendapatanPasanganPempolLainnya': '',
				'usiaProduktifPasanganPempol' : '',
				'rangeHasilInvestasiPempol': $scope.rangegajiPempols[0].id,
				'rangeHasilInvestasiPempolLainnya': '',
				'rangeGajiPempolJmlPempolLainnya': '',
				'rangeBisnisPempol': $scope.rangegajiPempols[0].id,
				'rangeBisnisPempolLainnya': '',
				'rangePendapatanOrangTuaPempol' : $scope.rangegajiPempols[0].id,
				'rangePendapatanOrangTuaPempolLainnya' : '',
				'usiaProduktifOrangTuaPempol' : '',
				'rangeBonusPempol': $scope.rangegajiPempols[0].id,
				'paymentBankNameLainnya': '',
				'rangeBonusPempolLainnya': '',
				'namaPerusahaanPempol': '',
				'alamatPerusahaanPempol': '',
				'kodeposPerusahaanPempol': '',
				'nomorTeleponPerusahaanPempol': '',
				'nomorEkstensiPerusahaanPempol': '',
				'isPagePekerjaanPempol1Accepted': '',
				'pemilikWirausahaPempol': '',
				'bidangWirausahaPempol': '',
				'namaWirausahaPempol': '',
				'alamatWirausahaPempol': ''
			}
		} else {
			$scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.pekerjaanPemegangPolis');
		}
		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {
				//console.log('Thank you for not eating my delicious ice cream cone');
			});
		};
	}
])
///////////////
///////////////////
.controller('produkDanManfaat12Ctrl', ['$state', '$scope', '$stateParams', 'spajProvider', 'dataFactory', '$store', '$ionicPopup',
	function ($state, $scope, $stateParams, spajProvider, dataFactory, $store, $ionicPopup) {
		$scope.jenisAsuransis = dataFactory.getJenisAsuransis();
		$scope.caraBayars = dataFactory.getCaraBayars();
		$scope.isShowRider = false;
		$scope.bayarBerikutnyas = dataFactory.getBayarBerikutnyas();
		$scope.jenisJsProteksiKeluargas = dataFactory.getJenisJsProteksiKeluargas();
		$scope.pctUnitlinkGuardians = dataFactory.getPctUnitlinkGuardians();
		$scope.jenisFunds = dataFactory.getjenisFunds();
		$scope.isShowTermRider = false;
		$scope.isShowADDB = false;
		$scope.isShowTPD = false;
		$scope.isShowCI53 = false;
		$scope.isShowhospitalCP = false;
		$scope.isShowPBD = false;
		$scope.isShowPBC151 = false;
		$scope.isShowPBTPD = false;
		$scope.isShowSPD = false;
		$scope.isShowSPCI51 = false;
		$scope.isShowSPTBD = false;
		$scope.isShowWPC151 = false;
		$scope.isShowWPTPD = false;
		$scope.isRiderLainnya = false;
		$scope.isRiderShow = false;
		$scope.isHcpTypeSelect = null;
		
		//17 Januari 2023 akomodir Label Anuitas
		$scope.labelUA = "Uang Asuransi";
		
		$scope.hubunganKeluargas = dataFactory.getHubunganKeluargas(); 
		$scope.genders = dataFactory.getGenders();
		
		$scope.$on('$ionicView.beforeEnter', function (event, viewData) {
			viewData.enableBack = true;
		});
		$scope.pageId = 'aplikasiSPAJOnline.produkDanManfaat12';
		//INIT FORM 
		$scope.$on('$ionicView.enter', function () {
			$scope.init_data();
			$scope.init_display();
			
				$scope.getRiderGroup($scope.data.jenisAsuransi);
				//setRiderDisplay
				$scope.setProspekRider();
		});
		prospek = false;
		try {
			$pros = JSON.parse(spajProvider.getProspekData());
			prospek = $pros.find(obj => {
				return obj.build_id === spajProvider.getBuildId()
			});
		} catch (e) {
			prospek = {
				'kdprovinsi': '0',
				'alamat': ''
			}
		}
		
		//console.log('test disini');
		//console.log(prospek.ispci);

		if(prospek.HCP_TYPE_SELECT != 0){
			$scope.isHcpTypeSelect = 'HCPM'+prospek.HCP_TYPE_SELECT+'00';
		}
		
		$scope.init_data = function () {

			//akomodir UAT 10 Januari 2023, produk ANUITAS
			let produkRegexAPP = /APP/i;
			let usiaPensiun = 0;
			let tglPensiunCtt = null;
			
			let masaBayarPremHitung = ((prospek.kd_produk == 'JL4BLN' || prospek.kd_produk == 'JL4BLN_' || prospek.kd_produk == 'JL4XN' || prospek.kd_produk == 'JL4SMR') ? "99" : (prospek.kd_produk == 'JSDMPPN')? "10":"5") - prospek.usiactt;
			let jangkaWaktuAsuransiHitung = ((prospek.kd_produk == 'JL4BLN' || prospek.kd_produk == 'JL4BLN_' || prospek.kd_produk == 'JL4XN' || prospek.kd_produk == 'JL4SMR') ? "99" : (prospek.kd_produk == 'JSDMPPN')? "10":"5") - prospek.usiactt;
			
			if(produkRegexAPP.test(prospek.kd_produk)){
				if(prospek.kd_produk == 'APPSH'){
					usiaPensiun = 99;
				}else if(prospek.kd_produk == 'APP85'){
					usiaPensiun = 85;
				}else if(prospek.kd_produk == 'APP75'){
					usiaPensiun = 75;
				}else if(prospek.kd_produk == 'APP65'){
					usiaPensiun = 65;
				}
				
				tglLahirCtt = new Date(prospek.tgllahirctt);
				tglPensiunCtt = new Date(tglLahirCtt.setFullYear(tglLahirCtt.getFullYear() + usiaPensiun));
				tglMulas = new Date();
				
				const dob = new Date(prospek.tgllahirctt).getTime();
				const dateToCompare = new Date().getTime();
				const age = (dateToCompare - dob) / (365 * 24 * 60 * 60 * 1000);
				ageDate = Math.floor(age);

				console.log("umurnya: " + ageDate);
				console.log("tgl Pensinya: " + tglPensiunCtt.toISOString());
				console.log("masa bayarnya: " + (usiaPensiun - ageDate) );
				
				masaBayarPremHitung = 1;
				jangkaWaktuAsuransiHitung = (usiaPensiun - ageDate);
				
				if(usiaPensiun == 99) jangkaWaktuAsuransiHitung = 99;
				
				$scope.labelUA = "Anuitas Sebulan";
			}

			//akomodir UAT 10 Januari 2023
			$scope.data = {
				'spaj_guid': spajProvider.getSpajGUID(),
				'jenisAsuransi': prospek.kd_produk, //$scope.jenisAsuransis[0].id,
				'namaProduk': prospek.namaproduk,
				'caraBayar': prospek.cara_bayar, //(prospek.kd_produk == 'JL4BLN' || prospek.kd_produk == 'JL4BLN_') ? "1" : (prospek.kd_produk == 'JSSPOA' || prospek.kd_produk == 'JL4XN')?"X":"1", //$scope.caraBayars[0].id,
				'namaCaraBayar': prospek.namacarabayar,
				'bayarPremiSelanjutnya': $scope.bayarBerikutnyas[0].id,
				'pctUnitlinkGuardian': $scope.pctUnitlinkGuardians[0].id,
				'isPremi': '',
				'isTujuanProteksi': false,
				'isTujuanTabungan': false,
				'isTujuanPendidikan': false,
				'isTujuanInvestasi': false,
				'isTujuanPensiun': false,
				'isTujuanLainnya': false,
				'tujuanAsuransiLainnya': '',
				'jenisJsProteksiKeluarga': $scope.jenisJsProteksiKeluargas[0].id,
				'unitPasarUang': 0,
				'pendapatanTetap': 0,
				'berimbang': 0,
				'ekuitas': 0,
				'totalPersenUnitLink': 0,
				'hospitalCP': prospek.IS_HCP_MURNI,
				'hcpTypeSelect': $scope.isHcpTypeSelect,
				'isRiderLainnya': false,
				'namaRiderLainnya': '',
				'riderLainnyaPremi': '',
				'isTermRider': prospek.IS_TL,
				'isADB': prospek.IS_ADB,
				'isADDB': prospek.IS_ADDB,
				'isTPD': prospek.IS_TPD,
				'isCI53': prospek.IS_CI,
				'isPBD': prospek.IS_PAYOR_DEATH,
				'isPBC151': prospek.ispci,
				'isPBTPD': prospek.IS_PAYOR_TPD,
				'isSPD': prospek.IS_SPOUSE_DEATH,
				'SPBCI' : prospek.issci,
				'isSPCI51': false,
				'isSPTBD': prospek.IS_SPOUSE_TPD,
				'isWPCI51': prospek.IS_WAIVER_CI,
				'isWPTPD': prospek.IS_WAIVER_TPD,
				'masaBayarPremi': masaBayarPremHitung,
				'premi': prospek.jumlah_premi,
				'uangAsuransi': prospek.jua,
				'jangkaWaktuAsuransi': jangkaWaktuAsuransiHitung,
				'nomorRekening': '',
				'namaRekening': prospek.nama,
				'paymentBankName': '',
				'isPageProdukManfaat1Accepted': false,
				'premiBerkala': prospek.premi_berkala,
				'topupBerkala': prospek.topup_berkala,
				'topupSekaligus': prospek.topup_sekaligus,
				'alokasiDana': prospek.kode_alokasi,
				'kode_alokasi1': prospek.kode_alokasi1,
				'kode_alokasi2': prospek.kode_alokasi2,
				'alokasi1': prospek.alokasi1,
				'alokasi2': prospek.alokasi2,
				'nama_alokasi1': prospek.nama_alokasi1,
				'nama_alokasi2': prospek.nama_alokasi2,
				'termRiderUA':prospek.TL,
				'adbUA':prospek.ADB,
				'addbUA':prospek.ADDB,
				'CI53UA':prospek.CI,
				'WPCI51UA':prospek.WAIVER_CI,
				'WPTPDUA':prospek.WAIVER_TPD,
				'tpdUA':prospek.TPD,
				'pempolIsPembayarPremi':false,
				'hubunganPembayarPremiDenganTTU' : $scope.hubunganKeluargas[0].id,
				'jenisKelaminPembayarPremi' : $scope.genders[0].id,
				'isRiderShow': (prospek.kd_produk == 'PAA' || prospek.kd_produk == 'PAB' || produkRegexAPP.test(prospek.kd_produk) ? false : true),
			}
			
			$scope.selectUnitInvestasi($scope.data.alokasiDana);
			if ($store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + $scope.pageId) == null) {} else {
				$scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + $scope.pageId);
			}
		}
		
		$scope.setProspekRider = function(){
			prospek = false;
			try {
					$pros = JSON.parse(spajProvider.getProspekData());
					prospek = $pros.find(obj => {
						return obj.build_id === spajProvider.getBuildId()
					});
			} catch (e) {
				console.log(e)
			}
			
			//$scope.data.isTermRider= 
			try{
				$scope.data.isADB	=prospek.IS_ADB;
				$scope.data.adbUA	= parseInt(prospek.ADB);
				$scope.data.isADDB	=prospek.IS_ADDB;
				$scope.data.addbUA	= parseInt(prospek.ADDB);
				$scope.data.isTPD	=prospek.IS_TPD;
				$scope.data.isCI53	=prospek.IS_CI;
				$scope.data.CI53UA	=prospek.CI;
				$scope.data.isPBD	=prospek.IS_PAYOR_DEATH;
				
				$scope.data.PBD	= parseInt(prospek.PAYOR_DEATH);
				//$scope.data.isPBC151=prospek.IS_PAYOR_CI;
				$scope.data.isPBC151=prospek.ispci;
				$scope.data.PBC151=parseInt(prospek.PAYOR_CI);
				$scope.data.isPBTPD	=prospek.IS_PAYOR_TPD;
				$scope.data.isSPD	=prospek.IS_SPOUSE_DEATH;
				$scope.data.SPBCI   = prospek.issci;
				$scope.data.isSPCI51=prospek.IS_SPOUSE_CI;
				$scope.data.isSPTBD	=prospek.IS_SPOUSE_TPD;
				$scope.data.isWPCI51=prospek.IS_WAIVER_CI;
				$scope.data.PBC151 = parseInt(prospek.pci);
				$scope.data.pbtpdUA = parseInt(prospek.PAYOR_TPD);
				$scope.data.WPCI51UA = parseInt(prospek.WAIVER_CI);
				$scope.data.isWPTPD	=prospek.IS_WAIVER_TPD;
				$scope.data.WPTPDUA = parseInt(prospek.WAIVER_TPD);
				$scope.data.SPOUSE_TPDUA = parseInt(prospek.SPOUSE_DEATH);
				$scope.data.SPOUSE_CIUA = parseInt(prospek.sci);
				$scope.data.SPOUSE_DEATHUA = parseInt(prospek.SPOUSE_TPD);
			}catch(e){
				
			}

			
		}
		
		$scope.setCaraBayarValues = function (kdproduk) {
			//console.log(kdproduk);
			$scope.caraBayars = dataFactory.getCaraBayars();
			cabay = $scope.caraBayars.filter(obj => {
				return (obj.kdproduk === '0' || obj.kdproduk === kdproduk)
			});
			$scope.caraBayars = cabay;
			$scope.data.caraBayars = kdproduk;
		}
		$scope.selectUnitInvestasi = function (x) {
			$scope.data.unitPasarUang = 0;
			$scope.data.pendapatanTetap = 0;
			$scope.data.berimbang = 0;
			$scope.data.ekuitas = 0;
			switch (x) {
			case '1':
				$scope.data.unitPasarUang = 100;
				break;
			case '2':
				$scope.data.pendapatanTetap = 100;
				break;
			case '3':
				$scope.data.berimbang = 100;
				break;
			case '4':
				$scope.data.ekuitas = 100;
				break;
			default:
				// code block
			}
			//$scope.data.alokasiDana = x;
			//console.log($scope.data);
		}
		$scope.init_display = function () {}
		$scope.saveDataSpaj = function () {
			let $formdata = {
				'pageId': $scope.pageId,
				'data': $scope.data
			};
			//console.log($formdata);
			spajProvider.setSpajGUID($scope.data.spaj_guid);
			$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + $formdata.pageId, $scope.data);
			spajProvider.setSpajElement($formdata);
			//$scope.showAlert('Test Display',angular.toJson(spajProvider.getSpajElement('aplikasiSPAJOnline.produkDanManfaat12'), true));
		}
		$scope.caraBayarFix = function (jenisAsuransi) {
			if (jenisAsuransi == "GUARDIAN" || jenisAsuransi == "PROIDAMAN" || jenisAsuransi == "UNITLINK") {
				$scope.data.caraBayar = "sekaligus";
				$scope.data.masaBayarPremi = 'X';
			}
		}
		$scope.pctTahun = function (jenisGuardian) {
			$scope.data.masaBayarPremi = 'X';
			$scope.data.jangkaWaktuAsuransi = jenisGuardian.substr(jenisGuardian.length - 1)
		}
		$scope.riderGroup = 0;
		$scope.getRiderGroup = function (produkid) {
			//console.log('a');
			for (i = 1; i < $scope.jenisAsuransis.length; i++) {
				if (produkid == $scope.jenisAsuransis[i].id) {
					$scope.riderGroup = $scope.jenisAsuransis[i].gruprider;
				}
			}
			this.setRiderDisplay($scope.riderGroup);
			return $scope.riderGroup;
		}
		$scope.setRiderDisplay = function (riderGroup) {
			if (riderGroup > 0) {
				$scope.isShowRider = true;
			} else {
				$scope.isShowRider = false;
			}
			
			riderGroup = parseInt(riderGroup);
			
			switch (riderGroup) {
			case 1: //JS Prestasi
				$scope.isShowTermRider = false;
				$scope.isShowADDB = false;
				$scope.isShowPBD = false;
				$scope.isShowPBC151 = false;
				$scope.isShowPBTPD = false;
				$scope.isShowSPD = false;
				$scope.isShowSPCI51 = false;
				$scope.isShowSPTBD = false;
				$scope.isShowWPC151 = false;
				$scope.isShowWPTPD = false;
				$scope.isRiderLainnya = false;
				$scope.isShowhospitalCP = true;
				$scope.isShowTPD = true;
				$scope.isShowCI53 = true;
				break;
			case 2: //JS Prestasi SMART
				$scope.isShowTermRider = false;
				$scope.isShowADDB = false;
				$scope.isShowTPD = false;
				$scope.isShowCI53 = false;
				$scope.isShowhospitalCP = false;
				$scope.isShowPBD = false;
				$scope.isShowPBC151 = false;
				$scope.isShowPBTPD = false;
				$scope.isShowSPD = false;
				$scope.isShowSPCI51 = false;
				$scope.isShowSPTBD = false;
				$scope.isShowWPC151 = false;
				$scope.isShowWPTPD = false;
				$scope.isRiderLainnya = false;
				$scope.isShowCI53 = true;
				break;
			case 3: //JS Beasiswa Catur Karsa Beasiswa Trikarsa Tri Pralaya JS Link Fixed Income Fun JS Link Equity Fund JS Link Balanced Fund JS Dwiguna JS Dwiguna Menaik
				$scope.isShowTermRider = true;
				$scope.isShowADB = true;
				$scope.isShowADDB = true;
				$scope.isShowTPD = true;
				$scope.isShowCI53 = true;
				$scope.isShowhospitalCP = true;
				$scope.isShowPBD = true;
				$scope.isShowPBC151 = true;
				$scope.isShowPBTPD = true;
				$scope.isShowSPD = true;
				$scope.isShowSPCI51 = true;
				$scope.isShowSPTBD = true;
				$scope.isShowWPC151 = true;
				$scope.isShowWPTPD = true;
				$scope.isRiderLainnya = true;
				$scope.isShowhospitalCP = true;
				$scope.isShowTermRider = true;
				$scope.isShowADB = true;
				$scope.isShowADDB = true;
				$scope.isShowTPD = true;
				$scope.isShowWPC151 = true;
				$scope.isShowWPTPD = true;
				$scope.isShowSPD = true;
				$scope.isShowSPTBD = true;
				$scope.isShowCI53 = true;
				break;
			case 4: //JS Beasiswa Catur Karsa Beasiswa Trikarsa Tri Pralaya JS Link Fixed Income Fun JS Link Equity Fund JS Link Balanced Fund JS Dwiguna JS Dwiguna Menaik
				$scope.isShowTermRider = true;
				$scope.isShowADDB = false;
				$scope.isShowTPD = false;
				$scope.isShowCI53 = true;
				$scope.isShowhospitalCP = true;
				$scope.isShowPBD = false;
				$scope.isShowPBC151 = false;
				$scope.isShowPBTPD = false;
				$scope.isShowSPD = false;
				$scope.isShowSPCI51 = false;
				$scope.isShowSPTBD = false;
				$scope.isShowWPC151 = false;
				$scope.isShowWPTPD = false;
				$scope.isRiderLainnya = false;
				break;
			case 5: //JS Beasiswa Catur Karsa Beasiswa Trikarsa Tri Pralaya JS Link Fixed Income Fun JS Link Equity Fund JS Link Balanced Fund JS Dwiguna JS Dwiguna Menaik
				$scope.isShowTermRider = false;
				$scope.isShowADDB = false;
				$scope.isShowTPD = false;
				$scope.isShowCI53 = false;
				$scope.isShowhospitalCP = false;
				$scope.isShowPBD = false;
				$scope.isShowPBC151 = false;
				$scope.isShowPBTPD = false;
				$scope.isShowSPD = false;
				$scope.isShowSPCI51 = false;
				$scope.isShowSPTBD = false;
				$scope.isShowWPC151 = false;
				$scope.isShowWPTPD = false;
				$scope.isRiderLainnya = false;
				$scope.isShowhospitalCP = true;
				$scope.isShowTermRider = false;
				$scope.isShowADDB = true;
				$scope.isShowTPD = true;
				$scope.isShowWPTPD = true;
				$scope.isShowSPD = true;
				$scope.isShowSPTBD = true;
				$scope.isShowCI53 = true;
				break;
			case 6: //JS Beasiswa Catur Karsa Beasiswa Trikarsa Tri Pralaya JS Link Fixed Income Fun JS Link Equity Fund JS Link Balanced Fund JS Dwiguna JS Dwiguna Menaik
				$scope.isShowTermRider = false;
				$scope.isShowADDB = false;
				$scope.isShowTPD = false;
				$scope.isShowCI53 = false;
				$scope.isShowhospitalCP = false;
				$scope.isShowPBD = false;
				$scope.isShowPBC151 = false;
				$scope.isShowPBTPD = false;
				$scope.isShowSPD = false;
				$scope.isShowSPCI51 = false;
				$scope.isShowSPTBD = false;
				$scope.isShowWPC151 = false;
				$scope.isShowWPTPD = false;
				$scope.isRiderLainnya = false;
				$scope.isShowhospitalCP = true;
				$scope.isShowTermRider = true;
				$scope.isShowADDB = true;
				$scope.isShowTPD = true;
				$scope.isShowCI53 = true;
				break;
			default:
				$scope.isShowTermRider = false;
				$scope.isShowADDB = false;
				$scope.isShowTPD = false;
				$scope.isShowCI53 = false;
				$scope.isShowhospitalCP = false;
				$scope.isShowPBD = false;
				$scope.isShowPBC151 = false;
				$scope.isShowPBTPD = false;
				$scope.isShowSPD = false;
				$scope.isShowSPCI51 = false;
				$scope.isShowSPTBD = false;
				$scope.isShowWPC151 = false;
				$scope.isShowWPTPD = false;
				$scope.isRiderLainnya = false;
				break;
			}
		}
		
		$scope.doCheck = function () {
			let ck = (1 * $scope.data.unitPasarUang) + (1 * $scope.data.pendapatanTetap) + (1 * $scope.data.berimbang) + (1 * $scope.data.ekuitas);
			if (ck > 100) {
				alert("Tidak boleh lebih dari 100%");
				return false;
			} else {
				$scope.data.totalPersenUnitLink = ck;
			}
		}
		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {
				//console.log('Thank you for not eating my delicious ice cream cone');
			});
		};

		

		$scope.validateThisFormOnPageAccept = function () {
			//validate datanya
			$scope.messages = [];
			try {
				if ($scope.data == null) {
					$scope.messages.push({
						"message": "Data ERROR. Null data."
					});
				}
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			try {

				if (!($scope.data.isTujuanLainnya || $scope.data.isTujuanProteksi || $scope.data.isTujuanTabungan || $scope.data.isTujuanPendidikan || $scope.data.isTujuanInvestasi || $scope.data.isTujuanPensiun)) {
					$scope.messages.push({
						'message': "Tujuan berasuransi harus diisi!"
					});
				}
				if ($scope.data.isTujuanLainnya) {
					tryMe = $scope.data.tujuanAsuransiLainnya;
					if ('' == tryMe) $scope.messages.push({
						'message': " Tujuan lainnya harus diisi!"
					});
				}
				if ($scope.data.paymentBankName == 'LAINNYA') {
					tryMe = $scope.data.paymentBankNameLainnya;
					if ('' == tryMe) $scope.messages.push({
						'message': "Nama Bank lainnya harus diisi!"
					});
				}
				if ('0' == $scope.data.jenisAsuransi) $scope.messages.push({
					'message': "Produk asuransi harus benar!"
				});

				

				if($scope.data.caraBayar == '0') scope.messages.push({
					'message': "Silahkan pilih cara membayar!"
				});


				/** Jika pembayar premi, bukan pemegang polis */
				if(!($scope.data.pempolIsPembayarPremi)){

					hubunganDenganTTU = $scope.data.hubunganPembayarPremiDenganTTU
					if(hubunganDenganTTU == '0') $scope.messages.push({
						'message': "Silahkan Pilih Hubungan dengan Tertanggung Utama!"
					});

					jenisKelamin = $scope.data.jenisKelaminPembayarPremi;
					if(jenisKelamin == '0') $scope.messages.push({
						'message': "Silahkan Pilih Jenis Kelamin Pembayar Premi!"
					});

					namaLengkap = $scope.data.namaPembayarPremi;
					if(namaLengkap == null) $scope.messages.push({
						'message': "Silahkan Masukkan Nama Lengkap Pembayar premi!"
					});

					noKtp = $scope.data.noKtpPembayarPremi;
					//console.log(noKtp);

					if(noKtp == null) $scope.messages.push({
						'message': "Silahkan Masukkan No. KTP Pembayar premi!"
					});

					if(noKtp != null){
						if(noKtp.length != 16){
							$scope.messages.push({
								'message': "No.Ktp tidak sesuai ketentuan! (16 Digit)"
							});		
						}
					}

					alamatKtp = $scope.data.alamatKTPtertanggung;
					if(alamatKtp == null) $scope.messages.push({
						'message': "Silahkan Masukkan Alamat KTP Pembayar premi!"
					});

					// console.log($scope.data.tglLahirPembayarPremi);
					tglLahir = $scope.data.tglLahirPembayarPremi;
					if(tglLahir == null ) $scope.messages.push({
						'message': "Silahkan Masukkan Tanggal Lahir Pembayar premi!"
					});

					tempatLahir = $scope.data.tempatLahirPembayarPremi;
					if(tempatLahir == null) $scope.messages.push({
						'message': "Silahkan Masukkan Tempat Lahir Pembayar premi!"
					});

					namaKantor = $scope.data.namaKantorPembayarPremi
					if(namaKantor == null || namaKantor == ''){
						$scope.messages.push({
							'message': "Nama Kantor Pembayar Premi masih kosong"
						});
					}

					alamatKantor = $scope.data.alamatKantorPembayarPremi
					if(alamatKantor == null || alamatKantor == ''){
						$scope.messages.push({
							'message': "Alamat Kantor Pembayar Premi masih kosong"
						});
					}

					noHp = $scope.data.nomorHpPembayarPremi
					if(noHp == null || noHp == ''){
						$scope.messages.push({
							'message': "No HP Pembayar Premi masih kosong"
						});
					}

					email = $scope.data.emailPembayarPremi
					if(email == null || email == '' || !(email.match(/\S+@\S+\.\S+/))){
						$scope.messages.push({
							'message': "Email Pembayar Premi harus benar"
						});
					}
				}
				/** End disini */

				// namaBank = $scope.data.namaBankPembPremi;
				// if(namaBank == null){
				// 	$scope.messages.push({
				// 		'message': "Bank Pembayaran Premi masih kosong"
				// 	});
				// }

				// cabangBank = $scope.data.cabangBankPembPremi;
				// if(cabangBank == null){
				// 	$scope.messages.push({
				// 		'message': "Cabang Bank Pembayaran Premi masih kosong"
				// 	});
				// }

				// noRek = $scope.data.nomorRekeningPembPremi;
				// if(noRek == null){
				// 	$scope.messages.push({
				// 		'message': "No Rekening Bank Pembayaran Premi masih kosong"
				// 	});
				// }

				// atasNama = $scope.data.namaRekeningPembPremi;
				// if(atasNama == null){
				// 	$scope.messages.push({
				// 		'message': "Atas Nama Rekening pembayaran premi masih kosong"
				// 	});
				// }

				if($scope.data.bayarPremiSelanjutnya == '0') $scope.messages.push({
					'message': "Silahkan Pilih Mekanisme Pembayaran!"
				});

				console.log($scope.data.bayarPremiSelanjutnya);

				if($scope.data.bayarPremiSelanjutnya != '0'){
					console.log($scope.data.paymentBankName)
					if($scope.data.paymentBankName == ''){
						$scope.messages.push({
							'message': "Silahkan Pilih Nama Bank Pembayaran!"
						});
					}

					if($scope.data.paymentBankName == 'LAINNYA'){
						console.log($scope.data.paymentBankNameLainnya)
						if($scope.data.paymentBankNameLainnya == null){
							$scope.messages.push({
								'message': "Silahkan Masukkan Nama Pembayaran Lainnya!"
							});
						}
						
					}
				}



				/*                     if ('0' == $scope.data.caraBayar) $scope.messages.push({
					                        'message': "Cara bayar harus benar!"
					                    });
					                    if ('' == $scope.data.masaBayarPremi) $scope.messages.push({
					                        'message': "Masa bayar premi harus benar!"
					                    }); */
				//if( (!parseInt($scope.data.premi) < 10000 && $scope.data.isPremi)
				//	|| (!parseInt($scope.data.uangAsuransi) < 10000 && $scope.data.isPremi) )
				//	$scope.messages.push({'message':"Jumlah Premi atau Uang Asuransi (Rp.) harus benar!"}) ;			
				if ('' == $scope.data.jangkaWaktuAsuransi) $scope.messages.push({
					'message': "Jangka waktu Asuransi harus benar!"
				});
				//if('' == $scope.data.nomorRekening)$scope.messages.push({'message':"Nomor rekening harus benar!"}) ;			
				//if('' == $scope.data.namaRekening)$scope.messages.push({'message':"Atas Nama Rekening harus benar!"}) ;			
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			// if($scope.data.isTermRider || $scope.data.isADB || $scope.data.isADDB || $scope.data.isTPD || $scope.data.isCI53 || $scope.data.isPBD || $scope.data.isPBC151 || $scope.data.isPBTPD || $scope.data.isSPD || $scope.data.SPBCI || $scope.data.isSPTBD || $scope.data.isWPCI51 || $scope.data.isWPTPD){
			// 	if($scope.data.termRiderUA == null || $scope.data.adbUA == null || $scope.data.addbUA == null || $scope.data.tpdUA == null || $scope.data.CI53UA == null || $scope.data.PBD == null || $scope.data.PBC151 == null || $scope.data.pbtpdUA == null || $scope.data.SPOUSE_TPDUA == null || $scope.data.SPOUSE_CIUA == null || $scope.data.SPOUSE_DEATHUA == null || $scope.data.WPCI51UA == null || $scope.data.WPTPDUA == null ){
			// 		$scope.messages.push({
			// 			'message': "Uang Asuransi harus diisi!"
			// 		});
			// 	}
			// }
			// if($scope.data.hospitalCP){
			// 	if(!($scope.data.hcpTypeSelect)){
			// 		$scope.messages.push({
			// 			'message': "Silahkan pilih tipe, HCP!"
			// 		});
			// 	}
			// }
			if ($scope.messages.length > 0) {
				return $scope.messages;
			}
			return false;
		}
		$scope.moveToNextPage = function () {
			if ($scope.validateThisFormOnPageAccept()) {
				$scope.showAlert('Validasi', spajProvider.alertMessagebuilder($scope.messages));
				$scope.data.isPageProdukManfaat1Accepted = false;
				return false;
			} else {
				if ($scope.data.isPageProdukManfaat1Accepted) {
					if (confirm('Langsung menuju ke halaman form isian penerima manfaat?')) {
						$state.go('aplikasiSPAJOnline.produkDanManfaat22', {}, {
							reload: true,
							inherit: false
						});
					} else {
						return false;
					}
				}
			}
		}
		$scope.isPageAccepted = function () {
			if (!$scope.data.isPageProdukManfaat1Accepted) {
				$scope.showAlert('Apakah data sudah benar?', 'Pastikan Anda yakin data sudah benar untuk melanjutkan kehalaman berikutnya.');
				return false;
			}
		}
	}
])
////////////
////////////
.controller('produkDanManfaat22Ctrl', ['$state', '$scope', '$stateParams', 'spajProvider', 'dataFactory', '$store', '$ionicPopup','$ionicLoading',
	function ($state, $scope, $stateParams, spajProvider, dataFactory, $store, $ionicPopup,$ionicLoading) {
		$scope.hubunganKeluargas = dataFactory.getHubunganKeluargas();
		$scope.dataPenerimaManfaat = spajProvider.getPenerimaManfaat(spajProvider.getSpajGUID(), 'aplikasiSPAJOnline.tambahPenerimaManfaat', false);
		$scope.length = null;
		if($scope.dataPenerimaManfaat != null){
			$scope.length = $scope.dataPenerimaManfaat.length;
		}
		

		prospek = false;
		try {
			$pros = JSON.parse(spajProvider.getProspekData());
			prospek = $pros.find(obj => {
				return obj.build_id === spajProvider.getBuildId()
			});
		} catch (e) {}
		
		$scope.pageId = 'aplikasiSPAJOnline.produkDanManfaat22';
		$scope.data = {
			'spaj_guid': spajProvider.getSpajGUID(),
				'namaBankPenerimaManfaat':'',
				'cabangBankPenerimaManfaat':'',
				'nomorRekeningPenerimaManfaat':'',
				'namaRekeningPenerimaManfaat':'',
		}
		if ($store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + $scope.pageId) == null) {} else {
			$scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + $scope.pageId);
		}

		$scope.saveDataSpaj = function () {
			let $formdata = {
				'pageId': $scope.pageId,
				'data': $scope.data
			};
			spajProvider.setSpajGUID($scope.data.spaj_guid);
			$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + $formdata.pageId, $scope.data);
			spajProvider.setSpajElement($formdata);
			//$scope.showAlert('Test Display',angular.toJson(spajProvider.getSpajElement('aplikasiSPAJOnline.produkDanManfaat12'), true));
		}
		
		$scope.editPenerimaManfaat = function (dat) {
			$state.go('aplikasiSPAJOnline.editPenerimaManfaat', {
				indexPenerimaManfaat: dat
			}, {
				reload: true,
				inherit: false
			});
		}
		$scope.$on('$ionicView.beforeEnter', function (event, viewData) {
			viewData.enableBack = true;
			if ($scope.dataPenerimaManfaat == null) {
				//'add from data tertanggung'
				$scope.dataTertanggung13 = $scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + 'aplikasiSPAJOnline.dataTertanggung13');
				$scope.dataTertanggung33 = $scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + 'aplikasiSPAJOnline.dataTertanggung33');
				if ($scope.dataTertanggung33 == null) {
					$scope.dataTertanggung33 = {
						'statusPernikahanTertanggung': ''
					}
				}
				$scope.newPenerimaManfaat = {
					'namaPenerimaManfaat': $scope.dataTertanggung13.namaLengkapTertanggung,
					'tglLahirPenerimaManfaat': new Date($scope.dataTertanggung13.tglLahirTertanggung),
					'tempatLahirPenerima': $scope.dataTertanggung13.tempatLahirTertanggung,
					'penerimaManfaatHubungan': '04',
					'statusPenerimaManfaat': $scope.dataTertanggung33.statusPernikahanTertanggung,
					'jenkelPenerimaManfaat': $scope.dataTertanggung13.jenkelTertanggung,
					'noKtpPenerimaManfaat': $scope.dataTertanggung13.nomorKTPTertanggung
				};
				spajProvider.addPenerimaManfaat(spajProvider.getSpajGUID(), 'aplikasiSPAJOnline.tambahPenerimaManfaat', $scope.newPenerimaManfaat);
				$scope.dataPenerimaManfaat = spajProvider.getPenerimaManfaat(spajProvider.getSpajGUID(), 'aplikasiSPAJOnline.tambahPenerimaManfaat', false);
			}
		}); console.log($scope.dataPenerimaManfaat);
		$scope.validateThisFormOnPageAccept = function () {
			$scope.messages = [];
			try {
				if ($scope.data == null) {
					$scope.messages.push({
						"message": "Data ERROR. Null data."
					});
				}

				
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}

			try {

				if($scope.dataPenerimaManfaat == null){
					$scope.messages.push({
						"message": "Belum ada Penerima Manfaat. Silahkan klik TAMBAH PENERIMA MANFAAT"
					});
				}

				if($scope.length == 1 && !(prospek.kd_produk.match(/APP/i))){
					$scope.messages.push({
						"message": "Silahkan Tambah Penerima Manfaat"
					});
				}

			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}

			if ($scope.messages.length > 0) {
				return $scope.messages;
			}
			return false;

			
		}
		
		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {
				//console.log('Thank you for not eating my delicious ice cream cone');
			});
		};
		$scope.moveToNextPage = function () {
			if ($scope.validateThisFormOnPageAccept()) {
				$scope.showAlert('Validasi', spajProvider.alertMessagebuilder($scope.messages));
				$scope.data.isPagePenerimaManfaatAccepted = false;
				return false;
			}else{
				if ($scope.data.isPagePenerimaManfaatAccepted) {
					
					// Jika produk PAA tidak perlu mengisi SKK
					//17 Januari 2023 add anuitas ga usah isi SKK
					if (prospek.kd_produk == 'PAA' || prospek.kd_produk == 'PAB' || prospek.kd_produk.match(/APP/i)) {
						if (confirm('Langsung menuju ke halaman form isian data pemegang polis?')) {
							$state.go('aplikasiSPAJOnline.dataPemegangPolis13', {}, {
								reload: true,
								inherit: false
							});
						} else {
							return false;
						}
					} else {
						if (confirm('Langsung menuju ke halaman form isian SKK?')) {
							if(confirm('Mohon menunggu halaman SKK tampil dengan sempurna.\n\n1 menit.')){
								$state.go('aplikasiSPAJOnline.sKKTertanggung', {}, {
									reload: true,
									inherit: false
								});
							}
	
						} else {
							return false;
						}
					}
				}
			}
		}
	}
])
/////////////
/////////////
.controller('sKKTertanggungUtamaCtrl', ['$scope', '$stateParams', 'spajProvider', 'dataFactory', '$store',
	function ($scope, $stateParams, spajProvider, dataFactory, $store) {
		$scope.$on('$ionicView.beforeEnter', function (event, viewData) {
			viewData.enableBack = true;
		});
		let $temp = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung13');
		$scope.jenkelTertanggungUtama = $temp.jenkelTertanggung;
		$scope.saveDataSpaj = function () {
			let $formdata = {
				'pageId': 'aplikasiSPAJOnline.sKKTertanggungUtama',
				'data': $scope.data
			};
			spajProvider.setSpajGUID($scope.data.spaj_guid);
			$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + $formdata.pageId, $scope.data);
			spajProvider.setSpajElement($formdata);
			//$scope.showAlert('Test Display',angular.toJson(spajProvider.getSpajElement('aplikasiSPAJOnline.sKKTertanggungUtama'), true));
		}
		if ($store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.sKKTertanggungUtama') == null) {
			$scope.data = {
				'spaj_guid': spajProvider.getSpajGUID(),
				'skkIsPenyakitKeturunan': false,
				'skkJenisPenyakitKeturunan': '',
				'skkIsRawatinap': false,
				'skkIsMerokok': false,
				'skkRokokBatangSehari': '',
				'skkIsNarkoba': false,
				'skkIsAlkohol': false,
				'jenkelTertanggung': '',
				'skkWanitaIsPapSmear': false,
				'skkWanitaIsHaidTerganggu': false,
				'skkWanitaIsHamil': false,
				'skkWanitaIsCesar': false,
				'skkWanitaIsKeguguran': false,
				'skkWanitaSulitLahir': false,
				'isSkkUtamaOk': false
			}
		} else {
			$scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.sKKTertanggungUtama');
		}
		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {
				//console.log('Thank you for not eating my delicious ice cream cone');
			});
		};
	}
])
/////////////
/////////////
.controller('sKKTertanggungTambahanCtrl', ['$scope', '$stateParams', 'spajProvider', 'dataFactory', '$store',
	function ($scope, $stateParams, spajProvider, dataFactory, $store) {
		$scope.$on('$ionicView.beforeEnter', function (event, viewData) {
			viewData.enableBack = true;
		});
		let $temp = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung13');
		$scope.jenkelTertanggungUtama = $temp.jenkelTertanggung;
		$scope.saveDataSpaj = function () {
			let $formdata = {
				'pageId': 'aplikasiSPAJOnline.sKKTertanggungTambahan',
				'data': $scope.data
			};
			spajProvider.setSpajGUID($scope.data.spaj_guid);
			$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + $formdata.pageId, $scope.data);
			spajProvider.setSpajElement($formdata);
			//$scope.showAlert('Test Display',angular.toJson(spajProvider.getSpajElement('aplikasiSPAJOnline.sKKTertanggungUtama'), true));
		}
		if ($store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.sKKTertanggungTambahan') == null) {
			$scope.data = {
				'spaj_guid': spajProvider.getSpajGUID(),
				'skkIsPenyakitKeturunan': false,
				'skkJenisPenyakitKeturunan': '',
				'skkIsRawatinap': false,
				'skkIsMerokok': false,
				'skkRokokBatangSehari': '',
				'skkIsNarkoba': false,
				'skkIsAlkohol': false,
				'jenkelTertanggung': '',
				'skkWanitaIsPapSmear': false,
				'skkWanitaIsHaidTerganggu': false,
				'skkWanitaIsHamil': false,
				'skkWanitaIsCesar': false,
				'skkWanitaIsKeguguran': false,
				'skkWanitaSulitLahir': false,
				'isSkkUtamaOk': false
			}
		} else {
			$scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.sKKTertanggungTambahan');
		}

		console.log($scope.data)

		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {
				//console.log('Thank you for not eating my delicious ice cream cone');
			});
		};
	}
])
/////////////
////////////
.controller('lembarPersetujuanCtrl', ['$scope', '$stateParams', 'spajProvider','$ionicPopup', 'dataFactory', '$store', '$state',
	function ($scope, $stateParams, spajProvider, $ionicPopup, dataFactory, $store, $state) {
		$scope.isProdukKeluarga = false;
		$scope.isProdukAkdp = false;
		$scope.isProdukOther = false;
		$scope.sumberDataTertanggung1  = false;
		$scope.sumberDataPempol1  = false;
		$scope.scroll = true;
		$scope.spaj_guid = spajProvider.getSpajGUID();
		$scope.isProdukUnitLink = false;
		
		if ($store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.produkDanManfaat12') == null) {
			alert('Mohon lengkapi halaman Produk dan Manfaat!');
			return false;
		} else {
			$scope.produkDanManfaat12 = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.produkDanManfaat12');
			if ($scope.produkDanManfaat12.jenisAsuransi == "JSPROTEKSIKELUARGA") {
				$scope.isProdukKeluarga = true;
			}else if($scope.produkDanManfaat12.jenisAsuransi.match(/JL/i)){
				$scope.isProdukOther = true;
				$scope.isProdukUnitLink = true;
			} else if ($scope.produkDanManfaat12.jenisAsuransi == "PAA" || $scope.produkDanManfaat12.jenisAsuransi == 'PAB') {
				$scope.isProdukAkdp = true;
			} else {
				$scope.isProdukOther = true;
			}
			
			$scope.sumberDataTertanggung1 = $store.get('SPAJ::' + $scope.spaj_guid + '::aplikasiSPAJOnline.dataTertanggung13');
			$scope.sumberDataPempol1 = $store.get('SPAJ::' + $scope.spaj_guid + '::aplikasiSPAJOnline.dataPemegangPolis13');
		}

		// $scope.$on('$ionicView.enter', function () {
		// 	$scope.init_data();
			
		// 	$scope.init_display();
		// });
		// $scope.init_display = function () {
		// 	return true;
		// };

		/// perubahan untuk LPA tanggal 18 juli
		prospek = false;
		$scope.dataAgen = null;
		try {
			$pros = JSON.parse(spajProvider.getProspekData());
			prospek = $pros.find(obj => {
				return obj.build_id === spajProvider.getBuildId()
			});
			console.log('kdjabatanagen', prospek.KDJABATANAGEN)
		} catch (e) {
			console.log(e);
		}
		
		if(prospek.KDJABATANAGEN == '29'){
			$scope.dataAgen = 'LPA';
		}else{
			$scope.dataAgen = 'Agen';
		}
		/// end perubahan lpa
		
		$scope.data = {
			'isMenyetujuiKetentuan': false,
			'isPageDokumentAccepted': false,
			'isMenyetujuiKetentuan': false,
			'pernahMemilikiPolis': false,
			'punyaPolisStatus': 'aktif',
			'sign1': '',
			'sign2': '',
			'sign3': '',
			'sign1enc': false,
			'sign3enc': false,
			'sign2enc': false,
			'kirimPolisKe': ''
		}
		// $scope.init_data = function () {
		// }
		

		$scope.validateThisFormOnPageAccept = function () {
			//validate datanya
			$scope.messages = [];
			try {
				if ($scope.data == null) {
					$scope.messages.push({
						"message": "Data ERROR. Null data."
					});
				}
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			//validate 
			try {

				kirimPolisKe = $scope.data.kirimPolisKe;
				if(!(kirimPolisKe)){
					$scope.messages.push({
						'message': "Mohon untuk pilih tujuan pengiriman polis!"
					});
				}

				agenMengenalSelama = $scope.data.agenMengenalSelama;
				if(!(agenMengenalSelama)){
					$scope.messages.push({
						'message': "Mohon untuk pilih salah satu, berapa lama anda saling mengenal!"
					});
				}

				nyatakanTertanggungUtamaSehat = $scope.data.nyatakanTertanggungUtamaSehat;
				if(!(nyatakanTertanggungUtamaSehat)){
					$scope.messages.push({
						'message': "Mohon untuk pilih salah satu, kondisi kesehatan anda saat ini!"
					});
				}

				nyatakanSesuaiKondisiKeuangan = $scope.data.nyatakanSesuaiKondisiKeuangan;
				if(!(nyatakanSesuaiKondisiKeuangan)){
					$scope.messages.push({
						'message': "Mohon untuk pilih salah satu, Kondisi keuangan anda saat ini!"
					});
				}

				penutupOleh = $scope.data.penutupOleh;
				if(!(penutupOleh)){
					$scope.messages.push({
						'message': "Mohon untuk pilih salah satu, yang memulai proses penutupan/closing asuransi jiwa!"
					});
				}

				sign1 = $scope.data.sign1;
				if(sign1 == ''){
					$scope.messages.push({
						'message': "Tanda Tangan Tertanggung Utama, masih kosong"
					});
				}

				sign2 = $scope.data.sign2;
				if(sign2 == ''){
					$scope.messages.push({
						'message': "Tanda Tangan Pemegang polis, masih kosong"
					});
				}

				sign3 = $scope.data.sign3;
				if(sign3 == ''){
					$scope.messages.push({
						'message': "Tanda Tangan Agen, masih kosong"
					});
				}


				isMengertiKetentuan = $scope.data.isMengertiKetentuan;
				if (isMengertiKetentuan != true) {
					$scope.messages.push({
						'message': "Mohon untuk menggeser tombol Mengerti Ketentuan untuk menyatakan!"
					});
				}



			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}

			if ($scope.messages.length > 0) {
				return $scope.messages;
			}
			return false;
		}

		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {
				//console.log('Thank you for not eating my delicious ice cream cone');
			});
		};

		$scope.moveToNextPage = function () {
			if ($scope.validateThisFormOnPageAccept()) {
				$scope.data.isMenyetujuiKetentuan = false;
				$scope.showAlert('Validasi', spajProvider.alertMessagebuilder($scope.messages));
				return false;
			} else {
				if ($scope.data.isMenyetujuiKetentuan) {
					if (confirm('Langsung menuju ke halaman form halaman kelengkapan Dokumen eSPAJ?')) {
						$state.go('aplikasiSPAJOnline.dokumenPendukungSPAJ', '', {
							reload: false,
							inherit: false
						});
					} else {
						$scope.data.isMenyetujuiKetentuan = false;
						return false;
					}
				}
			}
		}
		
		//console.log($scope.sumberDataTertanggung1);
		
		// $scope.moveToNextPage = function () {
		// 	/*                 if ($scope.data.sign1 == '' || $scope.data.sign1 == '') {
		// 		                    //-- blocked due UAT
		// 							//alert('Mohon tandatangani persetujuan ini sebelum melanjutkan!');
		// 		                    //$scope.data.isMengertiKetentuan = false;
		// 		                   // $scope.data.isMenyetujuiKetentuan = false;
		// 		                   // return false;
		// 		                } else { */
		// 	if (!$scope.data.sign1enc || !$scope.data.sign2enc || !$scope.data.sign3enc) {
		// 		//alert('Silahkan menandatangani terlebih dahulu.');
		// 		//return false;
		// 	}
		// 	if ($scope.data.isMenyetujuiKetentuan) {
		// 		if ($scope.data.isMengertiKetentuan) {
		// 			if (confirm('Langsung menuju ke halaman form halaman kelengkapan Dokumen eSPAJ?')) {
		// 				$state.go('aplikasiSPAJOnline.dokumenPendukungSPAJ', '', {
		// 					reload: false,
		// 					inherit: false
		// 				});
		// 			} else {
		// 				$scope.data.isMenyetujuiKetentuan = false;
		// 				return false;
		// 			}
		// 		} else {
		// 			alert('Mohon untuk menggeser tombol Mengerti Ketentuan untuk menyatakan');
		// 			return false;
		// 		}
		// 	}
		// 	// }
		// }
		if ($store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.lembarPersetujuan') == null) {
			$scope.data = {
				'buildid': spajProvider.getBuildId(),
				'spaj_guid': $scope.spaj_guid,
				'isMenyetujuiKetentuan': false,
				'isPageDokumentAccepted': false,
				'isMenyetujuiKetentuan': false,
				'pernahMemilikiPolis': false,
				'punyaPolisStatus': 'aktif',
				'sign1': '',
				'sign2': '',
				'sign3': '',
				'sign1enc': '',
				'sign2enc': '',
				'sign3enc': '',
				'kirimPolisKe': ''
			};
		} else {
			$scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.lembarPersetujuan');
			$scope.data.sign1enc = btoa(spajProvider.ioBase64.encode($scope.data.sign1));
			$scope.data.sign2enc = btoa(spajProvider.ioBase64.encode($scope.data.sign2));
			$scope.data.sign3enc = btoa(spajProvider.ioBase64.encode($scope.data.sign3));
		}
		
		
		$scope.saveDataSpaj = function () {

			$scope.data.sign1enc = btoa(spajProvider.ioBase64.encode($scope.data.sign1));
			$scope.data.sign2enc = btoa(spajProvider.ioBase64.encode($scope.data.sign2));
			$scope.data.sign3enc = btoa(spajProvider.ioBase64.encode($scope.data.sign3));
			let $formdata = {
				'pageId': 'aplikasiSPAJOnline.lembarPersetujuan',
				'data': $scope.data
			};
			console.log($scope.data);
			spajProvider.setSpajGUID($scope.data.spaj_guid);
			$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + $formdata.pageId, $scope.data);
			spajProvider.setSpajElement($formdata);
		}
		$scope.$on('$ionicView.beforeEnter', function (event, viewData) {
			viewData.enableBack = true;
		});
	}
])
////////////
/////////////
.controller('tinjauUlangDanKirimDokumenCtrl', ['$scope', '$state', '$stateParams', 'spajProvider', 'dataFactory', '$store', '$http', '$ionicLoading', '$ionicPopup', '$location', '$window', '$document',
	function ($scope, $state, $stateParams, spajProvider, dataFactory, $store, $http, $ionicLoading, $ionicPopup, $location, $window, $document) {
		$scope.spaj_guid = spajProvider.getSpajGUID();
		/* Gunakan base url yang dinamik jika pindah ke production klo development defaultkan ke aims */
		//$scope.baseurl = window.location.protocol + "//" + window.location.host;
		$scope.baseurl = 'https://aims.ifg-life.id';
		//$scope.baseurl = 'http://192.168.2.120/';

		$scope.idagen = getQueryParam('idagen');
		$scope.token = getQueryParam('token');
		$scope.android_ver = getQueryParam('android_ver');
		$scope.device = getQueryParam('device');
		$scope.tanggal_submit = Math.round(+new Date() / 1000);
		$scope.proposal_build_id = spajProvider.getBuildId();
		$scope.imageKtpTertanggung = null;
		$scope.imageKTPpempol = null;
		$scope.dokumens = null;
		
		$scope.sign1image = null;
		$scope.sign2image = null;
		$scope.sign3image = null;
		
		$scope.isValidDataTertanggung = false;
		$scope.isValidDataTertanggungTambahan = false;
		$scope.isValidDataPempol = false;
		$scope.isValidDataProdukManfaat = false;
		$scope.isValidDataPekerjaanTertanggung = false;
		$scope.isValidDataPekerjaanPempol = false;
		$scope.isValidDataSKKTU = false;
		$scope.isValidDataSKKTT = false;
		$scope.isValidDataPersetujuan = false;
		$scope.isValidDataDokumen = false;

		//17 Januari 2023 
		$scope.showSKKChecklist = true;
		$scope.labelUA = "Uang Asuransi";
		
		$scope.messages = [];
		//INIT FORM 
		$scope.$on('$ionicView.enter', function () {
			$scope.init_data();
			$scope.init_display();
		});
		$scope.init_display = function () {
			return true;
		};
		
		$scope.data_retrive = function () {
			$scope.messages = [];
			bol1 = false;
			bol2 = false;
			bol3 = false;
			//TERTANGGUNG
			$scope.sumberDataTertanggung1 = $store.get('SPAJ::' + $scope.spaj_guid + '::aplikasiSPAJOnline.dataTertanggung13');
			if ($scope.sumberDataTertanggung1 == null) {
				$scope.messages.push({
					'message': 'Silakan lengkapi data identitas tertanggung.'
				})
			} else {
				bol1 = true;
			}
			try {
				$scope.imageKtpTertanggung = atob(atob($scope.sumberDataTertanggung1.imageKTPTertanggung))
			} catch (e) {
				$scope.messages.push({
					'message': 'Invalid Image KTP Tertanggung ' + e
				});
			}
			$scope.sumberDataTertanggung2 = $store.get('SPAJ::' + $scope.spaj_guid + '::aplikasiSPAJOnline.dataTertanggung23');

			if ($scope.sumberDataTertanggung2 == null) {
				$scope.messages.push({
					'message': 'Silakan lengkapi data tempat tinggal tertanggung.'
				})
			} else {
				bol2 = true;
			};
			$scope.sumberDataTertanggung3 = $store.get('SPAJ::' + $scope.spaj_guid + '::aplikasiSPAJOnline.dataTertanggung33');
			if ($scope.sumberDataTertanggung3 == null) {
				$scope.messages.push({
					'message': 'Silakan lengkapi data pendukung tertanggung.'
				})
			} else {
				bol3 = true;
			};
			if (bol1 && bol2 && bol3) $scope.isValidDataTertanggung = true;
			bol1 = false;
			bol2 = false;
			bol3 = false;
			//generate envelope data tertanggung
			try {
				$scope.data_diri_tertanggung = angular.extend($scope.sumberDataTertanggung1, $scope.sumberDataTertanggung2, $scope.sumberDataTertanggung3)
				delete $scope.data_diri_tertanggung.spaj_guid;
			} catch (e) {
				console.log('Error merging Data tertangung' + e);
			}
			//TERTANGGUNG TAMBAHAM
			$scope.data_diri_tertanggung_tambahan = $scope.data_diri_tertanggung;
			//console.log($scope.data_diri_tertanggung_tambahan);
			
			$scope.tertanggung_tambahan_arr = dataFactory.toArray($scope.data_diri_tertanggung_tambahan);

			$scope.tertanggung_tambahan = [];
			try{
				if(parseInt($scope.data_diri_tertanggung_tambahan.jmlTertanggungTambahan) > 0){
					for($i=1;$i<= parseInt($scope.data_diri_tertanggung_tambahan.jmlTertanggungTambahan);$i++){
						$scope.tertanggung_tambahan.push(
							{"namaTertanggungTambahan":$scope.tertanggung_tambahan_arr['namaTertanggungTambahan'+$i]
								,"noKtpTertanggungTambahan":$scope.tertanggung_tambahan_arr['noKtpTertanggungTambahan'+$i]
								,"tglLahirTertanggungTambahan":$scope.tertanggung_tambahan_arr['tglLahirTertanggungTambahan'+$i]
								,"tempatLahirTertanggungTambahan":$scope.tertanggung_tambahan_arr['tempatLahirTertanggungTambahan'+$i]
								,"jenisKelaminTertanggungTambahan":$scope.tertanggung_tambahan_arr['jenisKelaminTertanggungTambahan'+$i]
								,"alamatKantorTertanggungTambahan":$scope.tertanggung_tambahan_arr['alamatKantorTertanggungTambahan'+$i]
								,"tinggiBadanTertanggungTambahan":$scope.tertanggung_tambahan_arr['tinggiBadanTertanggungTambahan'+$i]
								,"beratBadanTertanggungTambahan":$scope.tertanggung_tambahan_arr['beratBadanTertanggungTambahan'+$i]
								,"isTertanggungTambahanBekerja":$scope.tertanggung_tambahan_arr['isTertanggungTambahan'+$i+'Bekerja']
								,"hubunganDenganTTU":$scope.tertanggung_tambahan_arr['hubunganTT'+$i+'DenganTTU']
							}
						);
					}
				}
			}catch(e){
				console.log('error tertanggung tambahan!')
				console.log(e);
			}
			
			$scope.data_diri_tertanggung_tambahan = $scope.tertanggung_tambahan;
			$scope.tertanggung_tambahan = null;
			
			//console.log($scope.data_diri_tertanggung);
			//PEMPOL
			$scope.sumberDataPempol1 = $store.get('SPAJ::' + $scope.spaj_guid + '::aplikasiSPAJOnline.dataPemegangPolis13');
			if ($scope.sumberDataPempol1 == null) {
				$scope.messages.push({
					'message': 'Silakan lengkapi data identitas pemegang polis.'
				});
			} else {
				bol1 = true;
			}
			
			//18 January 2023
			try {
				$scope.imageKTPpempol = atob(atob($scope.sumberDataPempol1.imageKTPpempol));
				if(prospek.kd_produk.match(/APP/i)){
					//19 January 2023 Fix data pempol ktp
					$scope.imageKTPpempol = $scope.imageKtpTertanggung;
					
					//putback data image ktpnya to JSON pempol = tertanggung
					$scope.sumberDataPempol1.imageKTPpempol = $scope.sumberDataTertanggung1.imageKTPTertanggung;

				}
			} catch (e) {
				$scope.messages.push({
					'message': 'Invalid Image KTP Pempol ' + e
				});
			}
			$scope.sumberDataPempol2 = $store.get('SPAJ::' + $scope.spaj_guid + '::aplikasiSPAJOnline.dataPemegangPolis23');
			
			$scope.isSetujuEmail = $scope.sumberDataPempol2.isSetujuEmailPempol;
			$scope.isSetujuHP = $scope.sumberDataPempol2.isSetujuHPPempol;
			
			if ($scope.sumberDataPempol2 == null) {
				$scope.messages.push({
					'message': 'Silakan lengkapi data tempat tinggal pemegang polis.'
				})
			} else {
				bol2 = true;
			};
			$scope.sumberDataPempol3 = $store.get('SPAJ::' + $scope.spaj_guid + '::aplikasiSPAJOnline.dataPemegangPolis33');
			if ($scope.sumberDataPempol3 == null) {
				$scope.messages.push({
					'message': 'Silakan lengkapi data pendukung pemegang polis.'
				});
			} else {
				bol3 = true;
			}
			if (bol1 && bol2 && bol3) $scope.isValidDataPempol = true;
			bol1 = false;
			bol2 = false;
			bol3 = false;
			//generate envelope data pempol
			try {
				$scope.data_diri_pemegang_polis = angular.extend($scope.sumberDataPempol1, $scope.sumberDataPempol2, $scope.sumberDataPempol3)
				delete $scope.data_diri_pemegang_polis.spaj_guid;
			} catch (e) {
				console.log('Error merging Data Pemegang Polis' + e);
			}
			//console.log($scope.data_diri_pemegang_polis);
			//PEKERJAAN
			$scope.pekerjaanTertanggung = $store.get('SPAJ::' + $scope.spaj_guid + '::aplikasiSPAJOnline.pekerjaanTertanggung');
			if ($scope.pekerjaanTertanggung == null) {
				$scope.messages.push({
					'message': 'Silakan lengkapi data pekerjaan Tertanggung.'
				});
			} else {
				bol1 = true;
			}
			$scope.isValidDataPekerjaanTertanggung = bol1;
			$scope.pekerjaanPemegangPolis = $store.get('SPAJ::' + $scope.spaj_guid + '::aplikasiSPAJOnline.pekerjaanPemegangPolis');
			if ($scope.pekerjaanPemegangPolis == null) {
				if (!$scope.sumberDataPempol1.isTertanggungPempol) {
					$scope.messages.push({
						'message': 'Silakan lengkapi data pekerjaan pemegang polis.'
					});
				} else {
					bol2 = true;
					$scope.pekerjaanPemegangPolis = {
						'isTertanggungPempol': true
					};
				}
			} else {
				bol2 = true;
			}
			$scope.isValidDataPekerjaanPempol = bol2;
			//generate envelope PEKERJAAN
			try {
				$scope.data_pekerjaan_tertanggung = angular.extend($scope.pekerjaanTertanggung)
				$scope.data_pekerjaan_pempol = angular.extend($scope.pekerjaanPemegangPolis)
				delete $scope.data_pekerjaan_tertanggung.spaj_guid;
				delete $scope.data_pekerjaan_pempol.spaj_guid;
			} catch (e) {
				console.log('Error merging Data Pemegang Polis' + e);
			}
			//console.log($scope.data_pekerjaan_tertanggung);
			//console.log($scope.data_pekerjaan_pempol);
			/*bol1 = false;
			bol2 = false;
			bol3 = false;
			//SKK
			$scope.data_skk_utama = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.sKKTertanggung');
			//console.log($scope.data_skk_utama);
			if ($scope.data_skk_utama == null) {
				$scope.messages.push({
					'message': 'Silakan lengkapi SKK tertanggung utama'
				});
			} else {
				bol1 = true;
			}
			$scope.isValidDataSKKTU = bol1;
			$scope.isValidDataSKKTT = bol1;*/
			bol1 = false;
			bol2 = false;
			bol3 = false;
			
			//DOKUMEN N PRODUK
			//DOKUMEN N PRODUK
			$scope.data_dokumen = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dokumenPendukungSPAJ::dokumen_spaj');
			$scope.data_dokumens = [];
			if ($scope.data_dokumen == null) {
				$scope.messages.push({
					'message': 'Tidak Ada dokumen lampiran.'
				});
			} else {
				$scope.data_dokumen_arr = dataFactory.toArray($scope.data_dokumen);
				
				for($i=0;$i<$scope.data_dokumen_arr.length;$i++){
					$scope.data_dokumens.push(
						{
							"selectTipeDokumen":$scope.data_dokumen_arr[$i].selectTipeDokumen
							,"addNamaDokumen":$scope.data_dokumen_arr[$i].addNamaDokumen
							,"addKeteranganDokumen":$scope.data_dokumen_arr[$i].addKeteranganDokumen
							,"camDokumen":spajProvider.ioBase64.decode(spajProvider.ioBase64.decode($scope.data_dokumen_arr[$i].camDokumen))
						}
					)
				}

				bol1 = true;
			}
			//DOKUMEN N PRODUK
			//DOKUMEN N PRODUK
			
			
//pembayar Premi
//pembayar Premi

//pembayar Premi
//pembayar Premi
			
			$scope.data_produk = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.produkDanManfaat12');
			
			console.log($scope.data_produk);
			if ($scope.data_produk == null) {
				$scope.messages.push({
					'message': 'Silakan lengkapi form produk.'
				});
			} else {
				try{
					ter = dataFactory.getHubunganKeluargas();
				
					ter = ter.find(obj => {
						return obj.id === $scope.data_produk.hubunganPembayarPremiDenganTTU
					});
				
					$scope.data_produk.hubunganDenganTTUText = ter.label;
				}catch(e){
					$scope.data_produk.hubunganDenganTTUText = "";
				}
				bol1 = true;
			}
			
			$scope.data_manfaat = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.produkDanManfaat22');
			
			$scope.isValidDataProdukManfaat = true;
			bol1 = false;
			bol2 = false;
			bol3 = false;
			//PENERIMA MANFAAT
			$scope.data_penerima_manfaat = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.tambahPenerimaManfaat::penerima_manfaat');
			if ($scope.data_penerima_manfaat == null) $scope.messages.push({
				'message': 'Silakan lengkapi penerima manfaat.'
			});
			
			//DOKUMEN
			$scope.data_persetujuan = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.lembarPersetujuan');
			$scope.isMengertiKetentuan = $scope.data_persetujuan.isMengertiKetentuan;
			$scope.isMenyetujuiKetentuan = $scope.data_persetujuan.isMengertiKetentuan;
			
			
			if ($scope.data_persetujuan == null) {
				$scope.messages.push({
					'message': 'Silakan lengkapi tanda tanggan.'
				});
			} else {
				bol1 = true;
			}
			$scope.isValidDataDokumen = bol1;
			//PERSETUJUAN x
			$scope.data_persetujuan = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.lembarPersetujuan');

			if ($scope.data_persetujuan == null) {
				$scope.messages.push({
					'message': 'Silakan lengkapi dokumen.'
				});
			} else {
				bol1 = true;
			}
			$scope.isValidDataPersetujuan = bol1;
			try {
				//alert($scope.data_persetujuan.sign1);
				$scope.sign1image = $scope.data_persetujuan.sign1;
				$scope.sign2image = $scope.data_persetujuan.sign2;
				$scope.sign3image = $scope.data_persetujuan.sign3;
			} catch (e) {
				$scope.messages.push({
					'message': 'Invalid Image Sign ' + e
				});
			}
			bol1 = false;
			bol2 = false;
			bol3 = false;
			//SKK TERTANGGUNGNYA
			//17 Januari 2023 
			$scope.skk_tertanggung = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.sKKTertanggung');
			if ($scope.skk_tertanggung == null && $scope.data_produk.jenisAsuransi != 'PAA' && $scope.data_produk.jenisAsuransi != 'PAB' && !prospek.kd_produk.match(/APP/i)) {
				$scope.messages.push({
					'message': 'Silakan lengkapi form SKK.'
				});
			} else {
				bol1 = true;

				//17 January 2023
				if(prospek.kd_produk.match(/APP/i)){
					$scope.labelUA = "Anuitas Sebulan";
					$scope.showSKKChecklist = false;
				}
			}
			$scope.isValidDataSKKTU = bol1;
			$scope.isValidDataSKKTT = bol1;
			$scope.isVisibleSKK = !bol1;
			
		}
		
		
		$scope.init_data = function () {
			$scope.data_diri_tertanggung = '';
			$scope.data_diri_tertanggung_tambahan = '';
			$scope.data_diri_pemegang_polis = [];
			$scope.data_pekerjaan_pempol = '';
			$scope.data_pekerjaan_tertanggung = '';
			$scope.data_skk = [];
			$scope.data_penerima_manfaat = '';
			$scope.data_dokumen = '';
			$scope.data_produk = '';
			$scope.data_manfaat = '';
			$scope.data_persetujuan = '';
			$scope.data_retrive();
		}
		$scope.moveToDokumen = function () {
			$state.go('aplikasiSPAJOnline.dokumenPendukungSPAJ', '', {
				reload: true,
				inherit: false
			});
		}
		$scope.moveToPersetujuan = function () {
			$state.go('aplikasiSPAJOnline.lembarPersetujuan', '', {
				reload: true,
				inherit: false
			});
		}
		$scope.moveToTertanggung = function () {
			$state.go('aplikasiSPAJOnline.dataTertanggung13_tab1', '', {
				reload: false,
				inherit: false
			});
		}
		$scope.moveToTertanggungTambahan = function () {
			$state.go('aplikasiSPAJOnline.dataTertanggung33_tab1', '', {
				reload: true,
				inherit: false
			});
		}
		$scope.moveToSKK = function () {
			$state.go('aplikasiSPAJOnline.sKKTertanggung', {}, {
				reload: true,
				inherit: false
			});
		}
		$scope.moveToProduk = function () {
			$state.go('aplikasiSPAJOnline.produkDanManfaat12', '', {
				reload: true,
				inherit: false
			});
		}
		$scope.moveToPemegangPolis = function () {
			$state.go('aplikasiSPAJOnline.dataPemegangPolis13', '', {
				reload: false,
				inherit: false
			});
		}
		$scope.finalFormValidation = function () {
			//validate datanya
			return false;
		}
		$http2 = $http;
		$scope.envelope = null;
		$scope.submitToServer = function () {
			if (confirm('APAKAH ANDA INGIN MENGIRIM SPAJ INI?\n\nPastikan SPAJ telah diisi dengan benar dan ditandatangani Calon Nasabah.\n\nData yang telah terkirim TIDAK DAPAT DIUBAH kembali!\n\nJika Anda setuju kami akan mengirimkan OTP ke nomor Calon Nasabah ('+$scope.data_diri_pemegang_polis.nomorHpPempol+')')) {
				//bungkuss!!!
				$scope.envelope = {
					'id_agen': $scope.idagen,
					'spaj_guid': $scope.spaj_guid,
					'android_ver': $scope.android_ver,
					'device': $scope.device,
					'tanggal_submit': $scope.tanggal_submit,
					'proposal_build_id': $scope.sumberDataTertanggung1.build_id,
					'data_diri_tertanggung': $scope.data_diri_tertanggung,
					'data_diri_tertanggung_tambahan': $scope.data_diri_tertanggung_tambahan,
					'data_diri_pemegang_polis': $scope.data_diri_pemegang_polis,
					'data_pekerjaan_pempol': $scope.data_pekerjaan_pempol,
					'data_pekerjaan_tertanggung': $scope.data_pekerjaan_tertanggung,
					'data_skk': $scope.skk_tertanggung,
					'data_penerima_manfaat': $scope.data_penerima_manfaat,
					'data_dokumen': $scope.data_dokumen,
					'data_produk': $scope.data_produk,
					'data_manfaat': $scope.data_manfaat,
					'data_persetujuan': $scope.data_persetujuan,
				}
				
				//console.log($scope.envelope);
				
				if ($scope.messages.length == 0) {
					msisdn = $scope.data_diri_pemegang_polis.nomorHpPempol;
					//request OTP
					$scope.genOtp(msisdn);
					
					//$scope.submit($scope.envelope);
				} else {
					console.log($scope.messages);
					alert('eSPAJ tak dapat dikirim!\n\nPeriksa kembali checklist kelengkapan eSPAJ!');
					return false;
				}
			}
		}
		
		$scope.response = '';
		
		$scope.showPrompt = function(title,msg) {
			$ionicPopup.prompt({
				title: title,subTitle: msg
				}).then(function(res) {
					return res;
				});
		};
		
		$scope.genOtp = function (msisdn) {
			//let otpLink = "https://aims.ifg-life.id/mobileapi/spaj_bridge/get.php?act=gen_OTP&idagen=" + $scope.idagen + "&guid=" + $scope.spaj_guid + "&token=" + $scope.token + "&msisdn=" + msisdn;
			let otpLink = $scope.baseurl+"/mobileapi/spaj_bridge/get.php?act=gen_OTP&idagen=" + $scope.idagen + "&guid=" + $scope.spaj_guid + "&token=" + $scope.token + "&msisdn=" + msisdn;
			//console.log(otpLink);
			$scope.showSpinner('Mendapatkan OTP...');
			$http.post(otpLink, "spaj_guid=" + $scope.spaj_guid, {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
				}
			}).then(function (res) {
				if (res.data.status) {
					do {
						otpnya = prompt(res.data.message + "\n\nSilahkan validasi OTP yang berada dalam Inbox SMS HP Pemegang Polis terdaftar (6 Digit angka)", "");
						//optValidation = "https://aims.ifg-life.id/mobileapi/spaj_bridge/get.php?act=validate_OTP" + "&otp=" + otpnya + "&idagen=" + $scope.idagen + "&guid=" + $scope.spaj_guid + "&token=" + $scope.token;
						optValidation = $scope.baseurl+"/mobileapi/spaj_bridge/get.php?act=validate_OTP" + "&otp=" + otpnya + "&idagen=" + $scope.idagen + "&guid=" + $scope.spaj_guid + "&token=" + $scope.token;
						retSucc = false;
						$http.post(optValidation, "spaj_guid=" + $scope.spaj_guid, {
							headers: {
								'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
							}
						}).then(function (ret) {
							//ret = res;
							
							if (ret.data.status) {
								console.log('sending...');
								console.log($scope.baseurl+'/mobileapi/spaj_bridge/submitter.php?act=save_spaj' + '&idagen=' + $scope.idagen + '&token=' + $scope.token);
								console.log("spaj_guid=" + $scope.spaj_guid + "&data=" + angular.toJson($scope.envelope));
								//let link = 'https://aims.ifg-life.id/mobileapi/spaj_bridge/submitter.php?act=save_spaj' + '&idagen=' + $scope.idagen + '&token=' + $scope.token;
								let link = $scope.baseurl+'/mobileapi/spaj_bridge/submitter.php?act=save_spaj' + '&idagen=' + $scope.idagen + '&token=' + $scope.token;
								$scope.hideSpinner();
								$scope.showSpinner("Mengirim SPAJ Online...");
								$http.post(link, "spaj_guid=" + $scope.spaj_guid + "&data=" + angular.toJson($scope.envelope), {
									headers: {
										'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
									}
								}).then(function (rets) {
									$scope.hideSpinner();
									console.log(rets.data);
									$scope.showAlert('Status Pengiriman SPAJ', rets.data.message, true)
								}).withCredentials = true;
								
								
								/*do {
									otpnya = prompt(res.data.message + "\n\nSilahkan validasi OTP yang berada dalam Inbox SMS HP Pemegang Polis terdaftar (6 Digit angka)", "");
									optValidation = "https://aims.ifg-life.id/mobileapi/spaj_bridge/get.php?act=validate_OTP" + "&otp=" + otpnya + "&idagen=" + $scope.idagen + "&guid=" + $scope.spaj_guid + "&token=" + $scope.token;
									retSucc = false;
									$http.post(optValidation, "spaj_guid=" + $scope.spaj_guid, {
										headers: {
											'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
										}
									}).then(function (ret) {
										if (ret.data.status) {
											console.log(ret.data.status);
											//$scope.submit($scope.envelope);
											let link = 'https://aims.ifg-life.id/mobileapi/spaj_bridge/submitter.php?act=save_spaj' + '&idagen=' + $scope.idagen + '&token=' + $scope.token;
											$scope.hideSpinner();
											$scope.showSpinner("Mengirim SPAJ Online...");
											$http.post(link, "spaj_guid=" + $scope.spaj_guid + "&data=" + angular.toJson($scope.envelope), {
												headers: {
													'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
												}
											}).then(function (rets) {
												$scope.hideSpinner();
												console.log(rets.data);
												$scope.showAlert('Status Pengiriman SPAJ', rets.data.message, true)
											}).withCredentials = true;;
										} else {
											$scope.hideSpinner();
											alert('Gagal OTP');
										}
									}).withCredentials = true;
								} while (otpnya == "" || otpnya.length != 6);*/
							} else {
								/*do {
									otpnya = prompt(res.data.message + "\n\nSilahkan validasi OTP yang berada dalam Inbox SMS HP Pemegang Polis terdaftar (6 Digit angka)", "");
									optValidation = "https://aims.ifg-life.id/mobileapi/spaj_bridge/get.php?act=validate_OTP" + "&otp=" + otpnya + "&idagen=" + $scope.idagen + "&guid=" + $scope.spaj_guid + "&token=" + $scope.token;
									retSucc = false;
									$http.post(optValidation, "spaj_guid=" + $scope.spaj_guid, {
										headers: {
											'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
										}
									}).then(function (ret) {
										if (ret.data.status) {
											console.log(ret.data.status);
											//$scope.submit($scope.envelope);
											let link = 'https://aims.ifg-life.id/mobileapi/spaj_bridge/submitter.php?act=save_spaj' + '&idagen=' + $scope.idagen + '&token=' + $scope.token;
											$scope.hideSpinner();
											$scope.showSpinner("Mengirim SPAJ Online...");
											$http.post(link, "spaj_guid=" + $scope.spaj_guid + "&data=" + angular.toJson($scope.envelope), {
												headers: {
													'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
												}
											}).then(function (rets) {
												$scope.hideSpinner();
												console.log(rets.data);
												$scope.showAlert('Status Pengiriman SPAJ', rets.data.message, true)
											}).withCredentials = true;;
										} else {
											$scope.hideSpinner();
											alert('Gagal OTP');
										}
									}).withCredentials = true;;
								} while (otpnya == "" || otpnya.length != 6);*/
								
								$scope.hideSpinner();
								alert('Gagal OTP, Silahkan coba lagi.');
							}
						
						}).withCredentials = true;;
					} while (otpnya == "" || otpnya.length != 6);
				}
			}).withCredentials = true;
		}
		$scope.askOtp = function () {
			otpnya = "";
			do {
				otpnya = prompt(res.data.message + "\n\nSilahkan validasi OTP yang berada dalam Inbox SMS HP Pemegang Polis terdaftar (6 Digit angka)", "");
			} while (otpnya == "" || otpnya.length != 6);
			return otpnya;
		}
		$scope.validateOtp = function (otpnya) {
			alert(otpnya);
		}
		$scope.submit = function (param) {
				//let link = 'https://aims.ifg-life.id/mobileapi/spaj_bridge/submitter.php?act=save_spaj' + '&idagen=' + $scope.idagen + '&token=' + $scope.token;
				let link = $scope.baseurl+'/mobileapi/spaj_bridge/submitter.php?act=save_spaj' + '&idagen=' + $scope.idagen + '&token=' + $scope.token;
				console.log(link);
				console.log($scope.spaj_guid);
				console.log(angular.toJson(param));
				$scope.hideSpinner();
				$scope.showSpinner("Mengirim SPAJ Online...");
				$http.post(link, "spaj_guid=" + $scope.spaj_guid + "&data=" + angular.toJson(param), {
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
					}
				}).then(function (rets) {
					$scope.hideSpinner();
					console.log(rets.data);
					$scope.showAlert('Status Pengiriman SPAJ', rets.data.message, true)
				}).withCredentials = true;
			
		};
		$scope.$on('$ionicView.beforeEnter', function (event, viewData) {
			viewData.enableBack = true;
		});
		$scope.showSpinner = function (msg) {
			$ionicLoading.show({
				template: msg
			})
		};
		$scope.hideSpinner = function () {
			$ionicLoading.hide()
		};
		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {
				angular.element(document.querySelectorAll('#homeButton')).triggerHandler('click');
				spajProvider.delUnsavedSpajGuid($scope.spaj_guid);
			});
		};
	}
])
///////////
.controller('dokumenPendukungSPAJCtrl', ['$scope', '$stateParams', 'spajProvider', 'dataFactory', '$store', '$ionicPopup', '$state',
	function ($scope, $stateParams, spajProvider, dataFactory, $store, $ionicPopup, $state) {
		$scope.daftarDokumen = false;
		$scope.daftarDokumens = [];
		$scope.data = {
			'isPageDocumentAccepted': false
		}
		$scope.validateThisFormOnPageAccept = function () {
			//validate datanya
			$scope.messages = [];
			try {
				if ($scope.data == null) {
					$scope.messages.push({
						"message": "Data ERROR. Null data."
					});
				}
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			//validate nama, NOMOR KTP NPWP
			try {
				if (!($scope.data.isPageDocumentAccepted && ($scope.daftarDokumen != null) && $scope.daftarDokumen.length > 0)) {
					$scope.messages.push({
						'message': "Dokumen masih kosong."
					});
				}
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			if ($scope.messages.length > 0) {
				return $scope.messages;
			}
			return false;
		}

		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {});
		};

		$scope.moveToNextPage = function () {
			if ($scope.validateThisFormOnPageAccept()) {
				$scope.showAlert('Validasi', spajProvider.alertMessagebuilder($scope.messages));
				$scope.data.isPageDocumentAccepted = false;
				return false;
			} else{
				if($scope.data.isPageDocumentAccepted){
					if (confirm('Langsung menuju ke halaman form halaman SUBMIT eSPAJ?')) {
						$state.go('aplikasiSPAJOnline.tinjauUlangDanKirimDokumen', '', {
							reload: true,
							inherit: false
						});
					}else{
						return false;
					}
				}
			}
		}
		$scope.daftarDokumen = spajProvider.getDokumen(spajProvider.getSpajGUID(), 'aplikasiSPAJOnline.dokumenPendukungSPAJ', false);
		if ((typeof $scope.daftarDokumen == 'object') && ($scope.daftarDokumen != null)) {
			for (i = 0; i < $scope.daftarDokumen.length; i++) {
				$scope.daftarDokumens.push({
					'addKeteranganDokumen': $scope.daftarDokumen[i].addKeteranganDokumen,
					'addNamaDokumen': $scope.daftarDokumen[i].addNamaDokumen,
					'camDokumen': spajProvider.ioBase64.decode(spajProvider.ioBase64.decode($scope.daftarDokumen[i].camDokumen)),
					'selectTipeDokumen': $scope.daftarDokumen[i].selectTipeDokumen,
					'isPageDocumentAccepted': $scope.daftarDokumen[i].isPageDocumentAccepted
				})
			}
		}
		$scope.editDokumen = function (dat) {
			$state.go('aplikasiSPAJOnline.tambahkanDokumenPenunjangSPAJ', {
				indexDokumen: dat
			}, {
				reload: true,
				inherit: false
			});
		}
		$scope.$on('$ionicView.beforeEnter', function (event, viewData) {
			viewData.enableBack = true;
		});
	}
])
//etag: dokumen spaj
.controller('tambahkanDokumenPenunjangSPAJCtrl', ['$scope', '$stateParams', '$ionicPopup', 'dataFactory', 'spajProvider', '$store', '$state',
	function ($scope, $stateParams, $ionicPopup, dataFactory, spajProvider, $store, $state) {
		$scope.tipeDokumen = dataFactory.getTipeDokumens();
		$scope.indexDokumen = $state.params.indexDokumen;
		$scope.ngShow = true;
		if (typeof parseInt($scope.indexDokumen) && parseInt($scope.indexDokumen) > -1) {
			$scope.dataDokumen = spajProvider.getDokumen(spajProvider.getSpajGUID(), 'aplikasiSPAJOnline.dokumenPendukungSPAJ', $scope.indexDokumen);
			$scope.data = {
				'spaj_guid': spajProvider.getSpajGUID(),
				'addNamaDokumen': $scope.dataDokumen.addNamaDokumen,
				'addKeteranganDokumen': $scope.dataDokumen.addKeteranganDokumen,
				'selectTipeDokumen': $scope.dataDokumen.selectTipeDokumen,
				'camDokumen': spajProvider.ioBase64.decode(spajProvider.ioBase64.decode($scope.dataDokumen.camDokumen))
			}
			spajProvider.putImageTo('canvasDokumen', spajProvider.ioBase64.decode(spajProvider.ioBase64.decode($scope.dataDokumen.camDokumen)));
		} else {
			$scope.data = {
				'spaj_guid': spajProvider.getSpajGUID(),
				'addNamaDokumen': '',
				'addKeteranganDokumen': '',
				'selectTipeDokumen': $scope.tipeDokumen[0].id_sae,
				'camDokumen': ''
			}
			//console.log('loaded 2');
			//spajProvider.putImageTo('canvasDokumen',spajProvider.ioBase64.decode(spajProvider.ioBase64.decode($scope.dataDokumen.camDokumen)));
		}

		$scope.validateThisFormOnPageAccept = function () {
			//validate datanya
			$scope.messages = [];
			try {
				if ($scope.data == null) {
					$scope.messages.push({
						"message": "Data ERROR. Null data."
					});
				}
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			//validate 
			try {
				selectTipeDokumen = $scope.data.selectTipeDokumen;
				if (selectTipeDokumen == '0') {
					$scope.messages.push({
						'message': "Silahkan pilih tipe dokumen"
					});
				}

				addNamaDokumen = $scope.data.addNamaDokumen;
				if(addNamaDokumen == ''){
					$scope.messages.push({
						'message': "Nama Dokumen harus diisi!"
					})
				}

				addKeteranganDokumen = $scope.data.addKeteranganDokumen
				if(addKeteranganDokumen == ''){
					$scope.messages.push({
						'message': "Keterangan dokumen harus diisi!"
					})
				}

				camDokumen = $scope.data.camDokumen
				if(camDokumen == ''){
					$scope.messages.push({
						'message': "Silahkan upload foto dokumen!"
					})
				}

			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}
			if ($scope.messages.length > 0) {
				return $scope.messages;
			}
			return false;
		}

		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {
				console.log(res);
			});
		};

		$scope.delDokumen = function (indexDokumen) {
			if (confirm("yakin akan hapus dokumen ini>")) {
				spajProvider.delDokumen($scope.data.spaj_guid, 'aplikasiSPAJOnline.dokumenPendukungSPAJ', indexDokumen)
				$state.go('aplikasiSPAJOnline.dokumenPendukungSPAJ', {}, {
					reload: true,
					inherit: false,
					cache: false
				});
			} else {
				return false;
			}
		}
		$scope.saveDokumen = function () {
			if ($scope.validateThisFormOnPageAccept()) {
				$scope.showAlert('Validasi', spajProvider.alertMessagebuilder($scope.messages));
				return false;
			} else {
				if (typeof parseInt($scope.indexDokumen) && parseInt($scope.indexDokumen) > -1) {
					this.updateDokumen($scope.indexDokumen);
				} else {
					this.saveDataSpaj();
				}
				$state.go('aplikasiSPAJOnline.dokumenPendukungSPAJ', {}, {
					reload: true,
					inherit: false,
					cache: false
				});
			}
			// if ($scope.data.addNamaDokumen == '') {
			// 	alert('Nama Dokumen harus Diisi!');
			// 	return false;
			// } else {
			// 	if (typeof parseInt($scope.indexDokumen) && parseInt($scope.indexDokumen) > -1) {
			// 		this.updateDokumen($scope.indexDokumen);
			// 	} else {
			// 		this.saveDataSpaj();
			// 	}
			// 	$state.go('aplikasiSPAJOnline.dokumenPendukungSPAJ', {}, {
			// 		reload: true,
			// 		inherit: false,
			// 		cache: false
			// 	});
			// }
		}
		$scope.saveDataSpaj = function () {
			$scope.data.camDokumen = spajProvider.getImageBase64('canvasDokumen', 'jpg');
			$scope.newDokumen = {
				'addNamaDokumen': $scope.data.addNamaDokumen,
				'addKeteranganDokumen': $scope.data.addKeteranganDokumen,
				'selectTipeDokumen': $scope.data.selectTipeDokumen,
				'camDokumen': $scope.data.camDokumen
			};
			spajProvider.setSpajGUID($scope.data.spaj_guid);
			spajProvider.addDokumen($scope.data.spaj_guid, 'aplikasiSPAJOnline.dokumenPendukungSPAJ', $scope.newDokumen);
		}
		$scope.updateDokumen = function (indexDokumen) {
			$scope.data.camDokumen = spajProvider.getImageBase64('canvasDokumen', 'jpg');
			$scope.saveChanges = {
				'addNamaDokumen': $scope.data.addNamaDokumen,
				'addKeteranganDokumen': $scope.data.addKeteranganDokumen,
				'selectTipeDokumen': $scope.data.selectTipeDokumen,
				'camDokumen': $scope.data.camDokumen
			};
			spajProvider.setSpajGUID($scope.data.spaj_guid);
			spajProvider.updateDokumen($scope.data.spaj_guid, 'aplikasiSPAJOnline.dokumenPendukungSPAJ', indexDokumen, $scope.saveChanges);
		}
		$scope.changeImage = function () {
			document.getElementById('tempImgDokumen').style.display = 'none';
			spajProvider.takePict(this, 'canvasDokumen');
			$scope.data.camDokumen = spajProvider.getImageBase64('canvasDokumen', 'jpg');
		}
		$scope.$on('$ionicView.beforeEnter', function (event, viewData) {
			viewData.enableBack = true;
		});
	}
])
.controller('tambahPenerimaManfaatCtrl', ['$state', '$scope', '$stateParams', 'dataFactory', 'spajProvider', '$store', '$ionicPopup',
	function ($state, $scope, $stateParams, dataFactory, spajProvider, $store, $ionicPopup) {
		$scope.statuss = dataFactory.getStatusNikahs();
		$scope.hubunganKeluargas = dataFactory.getHubunganKeluargas();
		$scope.genders = dataFactory.getGenders();
		$scope.listTertanggungs = false;
		$scope.tertanggungs = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung33');
		$scope.daftarTertanggungs = [];
		if($scope.tertanggungs.jmlTertanggungTambahan > 0){
			for(i = 1;i<=$scope.tertanggungs.jmlTertanggungTambahan;i++){
				ter = dataFactory.toArray($scope.tertanggungs);

				tert = {
					'id':i
					,'namaPenerimaManfaat':ter['namaTertanggungTambahan'+i]
					,'tglLahirPenerimaManfaat':ter['tglLahirTertanggungTambahan'+i]
					,'noKtpPenerimaManfaat':ter['noKtpTertanggungTambahan'+i]
					,'jenkelPenerimaManfaat':ter['jenisKelaminTertanggungTambahan'+i]
					,'statusPenerimaManfaat':''
					,'penerimaManfaatHubungan':ter['hubunganTT'+i+'DenganTTU']
					,'tempatLahirPenerima':ter['tempatLahirTertanggungTambahan'+i]
				}
				$scope.daftarTertanggungs.push(tert);
			}
		
			$scope.listTertanggungs = $scope.daftarTertanggungs;
		}

		$scope.selectTertanggungs = function (idTertanggung){
			
			idTertanggung = idTertanggung -1;
			
			$scope.data.namaPenerimaManfaat = ($scope.daftarTertanggungs[idTertanggung]).namaPenerimaManfaat;
			$scope.data.tglLahirPenerimaManfaat = new Date (($scope.daftarTertanggungs[idTertanggung]).tglLahirPenerimaManfaat);
			$scope.data.noKtpPenerimaManfaat = ($scope.daftarTertanggungs[idTertanggung]).noKtpPenerimaManfaat;
			$scope.data.jenkelPenerimaManfaat = ($scope.daftarTertanggungs[idTertanggung]).jenkelPenerimaManfaat;
			$scope.data.statusPenerimaManfaat = ($scope.daftarTertanggungs[idTertanggung]).statusPenerimaManfaat;
			$scope.data.penerimaManfaatHubungan = ($scope.daftarTertanggungs[idTertanggung]).penerimaManfaatHubungan;
			$scope.data.tempatLahirPenerima = ($scope.daftarTertanggungs[idTertanggung]).tempatLahirPenerima;
			$scope.data.statusPenerimaManfaat = $scope.statuss[0].id;
		}

		$scope.saveDataSpaj = function () {
			$scope.newPenerimaManfaat = {
				'namaPenerimaManfaat': $scope.data.namaPenerimaManfaat,
				'tglLahirPenerimaManfaat': $scope.formatDate($scope.data.tglLahirPenerimaManfaat.toISOString()),
				'noKtpPenerimaManfaat': $scope.data.noKtpPenerimaManfaat,
				'tempatLahirPenerima': $scope.data.tempatLahirPenerima,
				'penerimaManfaatHubungan': $scope.data.penerimaManfaatHubungan,
				'statusPenerimaManfaat': $scope.data.statusPenerimaManfaat,
				'jenkelPenerimaManfaat': $scope.data.jenkelPenerimaManfaat
			};
			spajProvider.setSpajGUID($scope.data.spaj_guid);
			spajProvider.addPenerimaManfaat($scope.data.spaj_guid, 'aplikasiSPAJOnline.tambahPenerimaManfaat', $scope.newPenerimaManfaat);
		}

		$scope.data = {
			'spaj_guid': spajProvider.getSpajGUID(),
			'penerimaManfaatHubungan': $scope.hubunganKeluargas[0].id,
			'statusPenerimaManfaat': $scope.statuss[0].id,
			'jenkelPenerimaManfaat': $scope.genders[0].id,
			'namaPenerimaManfaat': '',
			'tglLahirPenerimaManfaat': '',
			'tempatLahirPenerima': '',
		}
		$scope.savePenerimaManfaat = function () {

			noKtp = $scope.data.noKtpPenerimaManfaat;
			if ($scope.data.penerimaManfaatHubungan == '0') {
				$scope.showAlert('Perhatian', 'Hubungan dengan tertanggung harus diisi.', true);
				return false;
			} else if (noKtp != '' && noKtp != null && noKtp.length != 16){
				$scope.showAlert('Perhatian', 'No NIK harus 16 Digit!', true);
				return false;
			} else if ($scope.data.namaPenerimaManfaat == ''){
				$scope.showAlert('Perhatian', 'Nama harus diisi.', true);
				return false;
			} else if ($scope.data.jenkelPenerimaManfaat == '0'){
				$scope.showAlert('Perhatian', 'Jenis kelamin harus diisi.', true);
				return false;
			} else if ($scope.data.tglLahirPenerimaManfaat == ''){
				$scope.showAlert('Perhatian', 'Tanggal lahir harus diisi.', true);
				return false;
			} else if ($scope.data.tempatLahirPenerima == ''){
				$scope.showAlert('Perhatian', 'Tempat lahir harus diisi.', true);
				return false;
			} else if ($scope.data.statusPenerimaManfaat == '0'){
				$scope.showAlert('Perhatian', 'Status Penerima Manfaat harus diisi.', true);
				return false;
			} else {
				this.saveDataSpaj();
				$state.go('aplikasiSPAJOnline.produkDanManfaat22', {}, {
					reload: true,
					inherit: false,
					cache: false
				});
			}


		}
		$scope.$on('$ionicView.beforeEnter', function (event, viewData) {
			viewData.enableBack = true;
		});
		
		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {});
		};
		
		$scope.formatDate = function(date) {
			let d = new Date(date),
				month = '' + (d.getMonth() + 1),
				day = '' + d.getDate(),
				year = d.getFullYear();

			if (month.length < 2) 
				month = '0' + month;
			if (day.length < 2) 
				day = '0' + day;

			return [year, month, day].join('-');
		}
		
		$scope.copyPenerimaManfaatFromPempol = function() {
			prospek = false;
			try {
				$pros = JSON.parse(spajProvider.getProspekData());
				prospek = $pros.find(obj => {
					return obj.build_id === spajProvider.getBuildId()
				});
			} catch (e) {}
			console.log(prospek)
			if ($scope.data.isTambahPenerimaManfaatPempol) {
				$scope.data.namaPenerimaManfaat = prospek.namacpp;
				$scope.data.tglLahirPenerimaManfaat = prospek.tgllahircpp;
				$scope.data.noKtpPenerimaManfaat = prospek.noktpcpp;
				$scope.data.jenkelPenerimaManfaat = prospek.kdjeniskelamincpp;
			} else {
				$scope.data.namaPenerimaManfaat = '';
				$scope.data.tglLahirPenerimaManfaat = '';
				$scope.data.noKtpPenerimaManfaat = '';
				$scope.data.jenkelPenerimaManfaat = '';
			}
			
			$scope.data.statusPenerimaManfaat = '0';
			$scope.data.penerimaManfaatHubungan = '0';
			$scope.data.tempatLahirPenerima = '';
		}
	}
])
.controller('editPenerimaManfaatCtrl', ['$state', '$scope', '$stateParams', 'spajProvider', 'dataFactory', '$store', '$filter', '$ionicPopup',
	function ($state, $scope, $stateParams, spajProvider, dataFactory, $store, $filter, $ionicPopup) {
		$scope.indexPenerimaManfaat = $state.params.indexPenerimaManfaat;
		//console.log(indexPenerimaManfaat);
		$scope.statuss = dataFactory.getStatusNikahs();
		$scope.hubunganKeluargas = dataFactory.getHubunganKeluargas();
		$scope.genders = dataFactory.getGenders();
		$scope.dataPenerimaManfaat = spajProvider.getPenerimaManfaat(spajProvider.getSpajGUID(), 'aplikasiSPAJOnline.tambahPenerimaManfaat', $scope.indexPenerimaManfaat);
		$scope.dataPenerimaManfaat.tglLahirPenerimaManfaat = new Date($scope.dataPenerimaManfaat.tglLahirPenerimaManfaat);
		
		$scope.listTertanggungs =false;
		$scope.tertanggungs = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung33');
		$scope.daftarTertanggungs = [];
		if($scope.tertanggungs.jmlTertanggungTambahan > 0){
			for(i = 1;i<=$scope.tertanggungs.jmlTertanggungTambahan;i++){
				ter = dataFactory.toArray($scope.tertanggungs);

				tert = {
					'id':i
					,'namaPenerimaManfaat':ter['namaTertanggungTambahan'+i]
					,'tglLahirPenerimaManfaat':ter['tglLahirTertanggungTambahan'+i]
					,'noKtpPenerimaManfaat':ter['noKtpTertanggungTambahan'+i]
					,'jenkelPenerimaManfaat':ter['jenisKelaminTertanggungTambahan'+i]
					,'statusPenerimaManfaat':''
					,'penerimaManfaatHubungan':ter['hubunganTT'+i+'DenganTTU']
					,'tempatLahirPenerima':ter['tempatLahirTertanggungTambahan'+i]
				}
				$scope.daftarTertanggungs.push(tert);
			}
		
		$scope.listTertanggungs = $scope.daftarTertanggungs;
		}

		$scope.selectTertanggungs = function (idTertanggung){
			
			idTertanggung = idTertanggung -1;
			
			$scope.data.namaPenerimaManfaat = ($scope.daftarTertanggungs[idTertanggung]).namaPenerimaManfaat;
			$scope.data.tglLahirPenerimaManfaat = new Date (($scope.daftarTertanggungs[idTertanggung]).tglLahirPenerimaManfaat);
			$scope.data.noKtpPenerimaManfaat = ($scope.daftarTertanggungs[idTertanggung]).noKtpPenerimaManfaat;
			$scope.data.jenkelPenerimaManfaat = ($scope.daftarTertanggungs[idTertanggung]).jenkelPenerimaManfaat;
			$scope.data.statusPenerimaManfaat = ($scope.daftarTertanggungs[idTertanggung]).statusPenerimaManfaat;
			$scope.data.penerimaManfaatHubungan = ($scope.daftarTertanggungs[idTertanggung]).penerimaManfaatHubungan;
			$scope.data.tempatLahirPenerima = ($scope.daftarTertanggungs[idTertanggung]).tempatLahirPenerima;
		}
		
		$scope.data = {
			'spaj_guid': spajProvider.getSpajGUID(),
			'penerimaManfaatHubungan': $scope.dataPenerimaManfaat.penerimaManfaatHubungan,
			'statusPenerimaManfaat': $scope.dataPenerimaManfaat.statusPenerimaManfaat,
			'jenkelPenerimaManfaat': $scope.dataPenerimaManfaat.jenkelPenerimaManfaat,
			'namaPenerimaManfaat': $scope.dataPenerimaManfaat.namaPenerimaManfaat,
			'tglLahirPenerimaManfaat': $scope.dataPenerimaManfaat.tglLahirPenerimaManfaat,
			'tempatLahirPenerima': $scope.dataPenerimaManfaat.tempatLahirPenerima,
			'noKtpPenerimaManfaat': $scope.dataPenerimaManfaat.noKtpPenerimaManfaat,
		}
		$scope.savePenerimaManfaat = function () {
			$scope.newPenerimaManfaat = {
				'namaPenerimaManfaat': $scope.data.namaPenerimaManfaat,
				'tglLahirPenerimaManfaat': $scope.formatDate($scope.data.tglLahirPenerimaManfaat.toISOString()),
				'tempatLahirPenerima': $scope.data.tempatLahirPenerima,
				'penerimaManfaatHubungan': $scope.data.penerimaManfaatHubungan,
				'statusPenerimaManfaat': $scope.data.statusPenerimaManfaat,
				'jenkelPenerimaManfaat': $scope.data.jenkelPenerimaManfaat,
				'noKtpPenerimaManfaat': $scope.data.noKtpPenerimaManfaat,
			};

			noKtp = $scope.data.noKtpPenerimaManfaat;
			if ($scope.data.penerimaManfaatHubungan == '0') {
				$scope.showAlert('Perhatian', 'Hubungan dengan tertanggung harus diisi.', true);
				return false;
			} else if (noKtp != '' && noKtp != null && noKtp.length != 16){
				$scope.showAlert('Perhatian', 'No NIK harus 16 Digit!', true);
				return false;
			} else if ($scope.data.namaPenerimaManfaat == ''){
				$scope.showAlert('Perhatian', 'Nama harus diisi.', true);
				return false;
			} else if ($scope.data.jenkelPenerimaManfaat == '0'){
				$scope.showAlert('Perhatian', 'Jenis kelamin harus diisi.', true);
				return false;
			} else if ($scope.data.tglLahirPenerimaManfaat == ''){
				$scope.showAlert('Perhatian', 'Tanggal lahir harus diisi.', true);
				return false;
			} else if ($scope.data.tempatLahirPenerima == ''){
				$scope.showAlert('Perhatian', 'Tempat lahir harus diisi.', true);
				return false;
			} else if ($scope.data.statusPenerimaManfaat == '0'){
				$scope.showAlert('Perhatian', 'Status Penerima Manfaat harus diisi.', true);
				return false;
			} else {
				if (confirm('yakin akan mengupdate?')) {
					spajProvider.updatePenerimaManfaat(spajProvider.getSpajGUID(), 'aplikasiSPAJOnline.tambahPenerimaManfaat', $scope.indexPenerimaManfaat, $scope.newPenerimaManfaat);
					$state.go('aplikasiSPAJOnline.produkDanManfaat22', {}, {
						reload: true,
						inherit: false,
						cache: false
					});
				};
			}

			// if (confirm('yakin akan mengupdate?')) {
			// 	spajProvider.updatePenerimaManfaat(spajProvider.getSpajGUID(), 'aplikasiSPAJOnline.tambahPenerimaManfaat', $scope.indexPenerimaManfaat, $scope.newPenerimaManfaat);
			// 	$state.go('aplikasiSPAJOnline.produkDanManfaat22', {}, {
			// 		reload: true,
			// 		inherit: false,
			// 		cache: false
			// 	});
			// };
		}

		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {});
		};
		
		$scope.formatDate = function(date) {
			let d = new Date(date),
				month = '' + (d.getMonth() + 1),
				day = '' + d.getDate(),
				year = d.getFullYear();

			if (month.length < 2) 
				month = '0' + month;
			if (day.length < 2) 
				day = '0' + day;

			return [year, month, day].join('-');
		}

		$scope.delPenerimaManfaat = function () {
			if (confirm('Yakin akan menghapus penerima manfaat bernama '+$scope.data.namaPenerimaManfaat+'?')) {
				spajProvider.removePenerimaManfaat(spajProvider.getSpajGUID(), 'aplikasiSPAJOnline.tambahPenerimaManfaat', $scope.indexPenerimaManfaat)
				$state.go('aplikasiSPAJOnline.produkDanManfaat22', {}, {
					reload: true,
					inherit: false,
					cache: false
				});
			};
		}
		$scope.$on('$ionicView.beforeEnter', function (event, viewData) {
			viewData.enableBack = true;
		});
	}
])
.controller('sPAJOnlineJiwasrayaCtrl', ['$scope', '$state', 'spajProvider', '$stateParams', '$http',
	function ($scope, $state, spajProvider, $stateParams, $http) {
		//ui-sref="aplikasiSPAJOnline.dataTertanggung13_tab1({new: true,spaj_guid:null})"
		$scope.idagen = getQueryParam('idagen');
		$scope.token = getQueryParam('token');
		$scope.android_ver = getQueryParam('android_ver');
		$scope.device = getQueryParam('device');
		

		
		
		$scope.newBuildId = function () {
			$http({
				method: "GET",
				url: "https://aims.ifg-life.id/mobileapi/spaj_bridge/get.php?act=get_build_id&idagen=" + $scope.idagen + "&token=" + $scope.token
			}).then(function mySucces(response) {
				spajProvider.setBuildId(null);
				spajProvider.setBuildId(response.data[0].BUILD_ID);
			})
		}
		$scope.newSpaj = function (spaj_guid) {
			spajProvider.setSpajGUID('new');
			$state.go('aplikasiSPAJOnline.dataTertanggung13_tab1', {
				spaj_guid: 'new'
			}, {
				reload: true,
				inherit: false
			});
		}
		$scope.$on('$ionicView.beforeEnter', function (event, viewData) {
			viewData.enableBack = true;
		});
	}
])

//////// PRINT ??? //////
/*
.controller('viewPrintSPAJCtrl', ['$scope', '$state', 'spajProvider', '$stateParams', '$http', '$ionicLoading', '$ionicModal',
	function ($scope, $state, spajProvider, $stateParams, $http, $ionicLoading, $ionicModal) {
		$scope.idagen = getQueryParam('idagen');
		$scope.token = getQueryParam('token');
		$scope.android_ver = getQueryParam('android_ver');
		$scope.device = getQueryParam('device');
		$scope.$on('$ionicView.beforeEnter', function (event, viewData) {
			viewData.enableBack = true;
		});
		$scope.spaj_guid = null;
		//TABEL_SPAJ_ONLINE
		$http({
			method: "GET",
			url: "http://192.168.1.10:7780/mobileapi/spaj_bridge/retriever.php?act=get_unprocessed&idagen=" + $scope.idagen + "&token=" + $scope.token
		}).then(function mySucces(response) {
			$tdata = [];
			if (response.data == null) {} else {
				for (i = 0; i < response.data.length; i++) {
					$tdata.push({
						'nama_pemegang_polis': response.data[i].nama_pemegang_polis,
						'nama_produk': response.data[i].nama_produk,
						'nama_tertanggung': response.data[i].nama_tertanggung,
						'premi': response.data[i].premi,
						'spaj_guid': response.data[i].spaj_guid,
						'tanggal_submit': spajProvider.convertDateFromUnixStamp(response.data[i].tanggal_submit)
					})
				}
			}
			$scope.dataUnprocessed = $tdata;
			$ionicLoading.hide();
		}, function myError(response) {
			$scope.dataUnprocessed = response.message;
			//
		}).withCredentials = true;;
		$tpl = null;
		$scope.modal = null;
		$scope.openModal = function ($spaj_guid) {
			$scope.spaj_guid = $spaj_guid;
			$urls = 'http://192.168.1.10:7780/mobileapi/spaj_bridge/view_detil_spaj.php?' + 'spaj_guid=' + $scope.spaj_guid + '&idagen=' + $scope.idagen + '&token=' + $scope.token + '&android_ver=23' + '&device=asus__ASUS_Z00A&app_version=1.0.641&act=view_detil_processed';
			$tpl = '<ion-modal-view style="top:0px;left:0px;position:absolute;width: 100%; height: 100%;">' + ' <ion-header-bar class="bar bar-header bar-positive"> ' + '<h1 class="title">View Data SPAJ ' + $scope.spaj_guid + '</h1> ' + '<button class="button button-clear button-primary" ' + 'ng-click="closeModal()">Close</button> </ion-header-bar> ' + '<ion-content class="padding"> <div class="list"> ' + '<button class="button button-full button-positive" id="maButton" ng-click="runReport(\'' + $scope.spaj_guid + '\')">Create</button>' + ' </div>' + '  <iframe id="pdfImage"  style="height:600px;width:100%;border:navy solid thin;" src="' + $urls + '"></iframe>  ' + '</ion-content> </ion-modal-view>';
			$scope.modal = $ionicModal.fromTemplate($tpl, {
				scope: $scope,
				animation: 'slide-in-up',
				focusFirstInput: true
			});
			$scope.modal.show($spaj_guid);
		};
		$scope.closeModal = function () {
			$scope.modal.hide();
		};
		//Cleanup the modal when we're done with it!
		$scope.$on('$destroy', function () {
			$scope.modal.remove();
		});
		// Execute action on hide modal
		$scope.$on('modal.hidden', function () {
			// Execute action
		});
		// Execute action on remove modal
		$scope.$on('modal.removed', function () {
			// Execute action
		});
		$scope.createContact = function (u) {
			$scope.contacts.push({
				name: u.firstName + ' ' + u.lastName
			});
			$scope.modal.hide();
		};
		//Function PDF
		$scope.runReport = _runReport;
		$scope.clearReport = _clearReport;
		_activate();

		function _activate() {
			//
			// ReportSvc Event Listeners: Progress/Done
			//    used to listen for async progress updates so loading text can change in 
			//    UI to be repsonsive because the report process can be 'lengthy' on 
			//    older devices (chk reportSvc for emitting events)
			//
			$scope.$on('ReportSvc::Progress', function (event, msg) {
				_showLoading(msg);
			});
			$scope.$on('ReportSvc::Done', function (event, err) {
				_hideLoading();
			});
		}

		function _runReport() {
			//if no cordova, then running in browser and need to use dataURL and iframe
			ReportSvc.runReportDataURL({}, {}).then(function (dataURL) {
				//set the iframe source to the dataURL created
				console.log('report run in browser using dataURL and iframe');
				document.getElementById('pdfImage').src = dataURL;
			});
			return true;
		}
		//reset the iframe to show the empty html page from app start
		function _clearReport() {
			document.getElementById('pdfImage').src = "empty.html";
		}

		function _showLoading(msg) {
			$ionicLoading.show({
				template: msg
			});
		}

		function _hideLoading() {
			$ionicLoading.hide();
		}
		//function PDF
		//function PDF
		//function PDF
		//function PDF
	}
])
*/
//////// PRINT ??? //////
.controller('suratKeteranganKesehatanCtrl', ['$scope', '$stateParams',
	function ($scope, $stateParams) {}
])
.controller('sKKTertanggungCtrl', ['$state', '$scope', '$stateParams', '$store', 'spajProvider', 'dataFactory', '$ionicPopup',
	function ($state, $scope, $stateParams, $store, spajProvider, dataFactory, $ionicPopup) {
		$scope.viewSKKas = "0";
		$scope.hobbys = dataFactory.getHobbys();
		$scope.pageId = 'aplikasiSPAJOnline.sKKTertanggung';
		$scope.$on('$ionicView.beforeEnter', function () {
			$scope.init_data();
			$scope.init_display();
		});
		
		$scope.jumlahSaudaraKandungs = [
			 {'id': 0,'label': 'Tidak Punya'}
			,{'id': 1,'label': '1'}
			,{'id': 2,'label': '2'}
			,{'id': 3,'label': '3'}
			,{'id': 4,'label': '4'}
			,{'id': 5,'label': '5'}
		];

		$scope.changeSkkView = function (skk){
				$scope.viewSKKas = skk;
		}
		
		prospek = false;
		try {
			$pros = JSON.parse(spajProvider.getProspekData());
			prospek = $pros.find(obj => {
				return obj.build_id === spajProvider.getBuildId()
			});
		} catch (e) {}
		
		/** WARNING!!! Quirks mode HERE **/
		/** WARNING!!! Quirks mode HERE **/
		/** WARNING!!! Quirks mode HERE **/
		$scope.init_display = function () {
			if ($store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.produkDanManfaat12') == null) {
				$scope.isProdukJsProteksiKeluarga = false;
				$scope.jenisProduk = false;
				$scope.jenisJsProteksiKeluarga = '';
				$scope.jmlTertanggungTambahan = '';
				$scope.namaTertanggungUtama = '';
				$scope.namaTertanggungTambahan1 = '';
				$scope.namaTertanggungTambahan2 = '';
				$scope.namaTertanggungTambahan3 = '';
				$scope.namaTertanggungTambahan4 = '';
				
				$scope.isTTUWanita = false;
				$scope.isTT1Wanita = false;
				$scope.isTT2Wanita = false;
				$scope.isTT3Wanita = false;
				$scope.isTT4Wanita = false;
				
			} else {
				$scope.isProdukJsProteksiKeluarga = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.produkDanManfaat12').jenisAsuransi;
				$scope.jenisJsProteksiKeluarga = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.produkDanManfaat12').jenisJsProteksiKeluarga;
				$scope.jenisProduk = $scope.isProdukJsProteksiKeluarga;
				$scope.jmlTertanggungTambahan = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung33').jmlTertanggungTambahan;
				$scope.isAdaTertanggungTambahan1 = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung33').isAdaTertanggungTambahan1;
				$scope.namaTertanggungUtama = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung13').namaLengkapTertanggung;
	
				///console.log($scope.jmlTertanggungTambahan );

				$scope.isTTUWanita = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung13').jenkelTertanggung;
				$scope.isTT1Wanita = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung33').jenisKelaminTertanggungTambahan1;
				$scope.isTT2Wanita = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung33').jenisKelaminTertanggungTambahan2;
				$scope.isTT3Wanita = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung33').jenisKelaminTertanggungTambahan3;
				$scope.isTT4Wanita = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung33').jenisKelaminTertanggungTambahan4;

				$scope.isTTUWanita = ($scope.isTTUWanita == 'L')?false:true;
				$scope.isTT1Wanita = ($scope.isTT1Wanita == 'L')?false:true;
				$scope.isTT2Wanita = ($scope.isTT2Wanita == 'L')?false:true;
				$scope.isTT3Wanita = ($scope.isTT3Wanita == 'L')?false:true;
				$scope.isTT4Wanita = ($scope.isTT4Wanita == 'L')?false:true;

				if($scope.isAdaTertanggungTambahan1){
					$scope.namaTertanggungTambahan1 = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung33').namaTertanggungTambahan1;
					$scope.namaTertanggungTambahan2 = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung33').namaTertanggungTambahan2;
					$scope.namaTertanggungTambahan3 = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung33').namaTertanggungTambahan3;
					$scope.namaTertanggungTambahan4 = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung33').namaTertanggungTambahan4;
				}

				$scope.isProdukJsProteksiKeluarga = ('JSPROTEKSIKELUARGA' == $scope.isProdukJsProteksiKeluarga);
				//console.log($scope.jenisJsProteksiKeluarga)
				/*switch ($scope.jenisJsProteksiKeluarga) {
				case 'K0':
					$scope.data.isAdaTTU = true;
					$scope.data.isAdaTT1 = true;
					$scope.data.isAdaTT2 = false;
					$scope.data.isAdaTT3 = false;
					$scope.data.isAdaTT4 = false;
					break;
				case 'K1':
					$scope.data.isAdaTTU = true;
					$scope.data.isAdaTT1 = true;
					$scope.data.isAdaTT2 = true;
					$scope.data.isAdaTT3 = false;
					$scope.data.isAdaTT4 = false;
					break;
				case 'K2':
					$scope.data.isAdaTTU = true;
					$scope.data.isAdaTT1 = true;
					$scope.data.isAdaTT2 = true;
					$scope.data.isAdaTT3 = true;
					$scope.data.isAdaTT4 = false;
					break;
				case 'K3':
					$scope.data.isAdaTTU = true;
					$scope.data.isAdaTT1 = true;
					$scope.data.isAdaTT2 = true;
					$scope.data.isAdaTT3 = true;
					$scope.data.isAdaTT4 = true;
					break;
				case 'B0':
					$scope.data.isAdaTTU = true;
					$scope.data.isAdaTT1 = false;
					$scope.data.isAdaTT2 = false;
					$scope.data.isAdaTT3 = false;
					$scope.data.isAdaTT4 = false;
					break;
				}
			 */
			}
			
			$scope.validateCompleteSKK = function(){
				$scope.data.isSKKLengkap = true;

				// scpArr =  dataFactory.toArray($scope.data);
				
				// if($scope.jmlTertanggungTambahan > 0){
				// 	for(i=1; i <= $scope.jmlTertanggungTambahan; i++){
				// 		$scope.data.isSKKLengkap = (
				// 				$scope.data.isSKKLengkap == ( $scope.data.isSKKLengkap && parseInt(scpArr['umurAyahTT'+i]) > 0 ) 
				// 			) && parseInt(scpArr['umurAyahTTU']) > 16 && parseInt(scpArr['umurIbuTTU']) > 16;
				// 	}
				// 	//console.log($scope.data.isSKKLengkap);
				// }else if(scpArr['umurAyahTTU'] > 16 && scpArr['umurIbuTTU'] > 16){
				// 	$scope.data.isSKKLengkap = true;
				// 	//console.log($scope.data.isSKKLengkap);
				// }

			}

			$scope.data_tertanggung3 = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung33');
			$scope.data_tertanggung1 = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::aplikasiSPAJOnline.dataTertanggung13');
			if ($scope.data_tertanggung3 != null || $scope.data_tertanggung1 != null) {
				if ($scope.data_tertanggung3.isAdaTertanggungTambahan1) $scope.isTertanggungTambahan = true;
				if ($scope.data_tertanggung3.jenisKelaminTertanggungTambahan1 == 'P' && $scope.data_tertanggung3.isAdaTertanggungTambahan1) $scope.isTT1Wanita = true;
				if ($scope.data_tertanggung1.jenkelTertanggung == 'P' && $scope.data_tertanggung1.namaLengkapTertanggung != '') $scope.isTTUWanita = true;
				if ($scope.data_tertanggung1.namaLengkapTertanggung != '' || $scope.data_tertanggung1.agamaTertanggung != '0') $scope.isHanya1tertanggung = true;;
				if ($scope.data_tertanggung1.namaLengkapTertanggung != '' || $scope.data_tertanggung1.agamaTertanggung != '0') $scope.isHanya1tertanggung = true;;
			} else {
				alert('Mohon lengkapi data Tertanggung atau Tertanggung tambahan!');
				return false;
				$state.go('aplikasiSPAJOnline.dataTertanggung13_tab1', {
					'spaj_guid': spaj_guid
				}, {
					reload: true,
					inherit: false
				});
				
			}
		}

		$scope.saveDataSpaj = function () {
			
			$scope.validateCompleteSKK();
			
			let $formdata = {
				'pageId': 'aplikasiSPAJOnline.sKKTertanggung',
				'data': $scope.data
			};
			console.log($scope.data);
			spajProvider.setSpajGUID($scope.data.spaj_guid);
			
			//$scope.data.tglMeninggalAyah_TTU = new Date($scope.data.tglMeninggalAyah_TTU);
			//$scope.data.tglMeninggalIbu_TTU = new Date($scope.data.tglMeninggalIbu_TTU);		

			//$scope.data.tglMeninggalAyah_TT1 = new Date($scope.data.tglMeninggalAyah_TT1);
			//$scope.data.tglMeninggalIbu_TT1 = new Date($scope.data.tglMeninggalIbu_TT1);
			
			$scope.data.tglMeninggalAyah_TT2 = new Date($scope.data.tglMeninggalAyah_TT2);
			$scope.data.tglMeninggalIbu_TT2 = new Date($scope.data.tglMeninggalIbu_TT2);
			
			$scope.data.tglMeninggalAyah_TT3 = new Date($scope.data.tglMeninggalAyah_TT3);
			$scope.data.tglMeninggalIbu_TT3 = new Date($scope.data.tglMeninggalIbu_TT3);
			
			$scope.data.tglMeninggalAyah_TT4 = new Date($scope.data.tglMeninggalAyah_TT4);
			$scope.data.tglMeninggalIbu_TT4 = new Date($scope.data.tglMeninggalIbu_TT4);

			if (!$scope.data.isAyahHidup_TTU && typeof $scope.data.isAyahHidup_TTU !== 'undefined') {
				console.log('meninggal');
				$scope.data.showAyahMeninggal_TTU = true;
				$scope.data.showAyahHidup_TTU = false;
				$scope.data.showAyahHidupTidakSehat_TTU = false;
			} else if ($scope.data.isAyahHidup_TTU && typeof $scope.data.isAyahHidup_TTU !== 'undefined') {
				console.log('hidup');
				$scope.data.showAyahMeninggal_TTU = false;
				$scope.data.showAyahHidup_TTU = true;
				
				if ($scope.data.isAyahHidupSehat_TTU && typeof $scope.data.isAyahHidupSehat_TTU !== 'undefined') { 
					console.log('sehat');
					$scope.data.showAyahHidupTidakSehat_TTU = false;
				} else if (!$scope.data.isAyahHidupSehat_TTU && typeof $scope.data.isAyahHidupSehat_TTU !== 'undefined') { 
					console.log('sakit');
					$scope.data.showAyahHidupTidakSehat_TTU = true;
				}
			}
			
			if (!$scope.data.isIbuHidup_TTU && typeof $scope.data.isIbuHidup_TTU !== 'undefined') {
				console.log('meninggal');
				$scope.data.showIbuMeninggal_TTU = true;
				$scope.data.showIbuHidup_TTU = false;
				$scope.data.showIbuHidupTidakSehat_TTU = false;
			} else if ($scope.data.isIbuHidup_TTU && typeof $scope.data.isIbuHidup_TTU !== 'undefined') {
				console.log('hidup');
				$scope.data.showIbuMeninggal_TTU = false;
				$scope.data.showIbuHidup_TTU = true;
				
				if ($scope.data.isIbuHidupSehat_TTU && typeof $scope.data.isIbuHidupSehat_TTU !== 'undefined') { 
					console.log('sehat');
					$scope.data.showIbuHidupTidakSehat_TTU = false;
				} else if (!$scope.data.isIbuHidupSehat_TTU && typeof $scope.data.isIbuHidupSehat_TTU !== 'undefined') { 
					console.log('sakit');
					$scope.data.showIbuHidupTidakSehat_TTU = true;
				}
			}
			
			if (!$scope.data.isPasanganHidup_TTU && typeof $scope.data.isPasanganHidup_TTU !== 'undefined') {
				console.log('meninggal');
				$scope.data.showPasanganMeninggal_TTU = true;
				$scope.data.showPasanganHidup_TTU = false;
				$scope.data.showPasanganHidupTidakSehat_TTU = false;
			} else if ($scope.data.isPasanganHidup_TTU && typeof $scope.data.isPasanganHidup_TTU !== 'undefined') {
				console.log('hidup');
				$scope.data.showPasanganMeninggal_TTU = false;
				$scope.data.showPasanganHidup_TTU = true;
				
				if ($scope.data.isPasanganHidupSehat_TTU && typeof $scope.data.isPasanganHidupSehat_TTU !== 'undefined') { 
					console.log('sehat');
					$scope.data.showPasanganHidupTidakSehat_TTU = false;
				} else if (!$scope.data.isPasanganHidupSehat_TTU && typeof $scope.data.isPasanganHidupSehat_TTU !== 'undefined') { 
					console.log('sakit');
					$scope.data.showPasanganHidupTidakSehat_TTU = true;
				}
			}

			/** Tertanggung Tambahan */
			if($scope.isTertanggungTambahan){


				/** Tertanggung Tambahan 1 */
				if (!$scope.data.isAyahHidup_TT1 && typeof $scope.data.isAyahHidup_TT1 !== 'undefined') {
					console.log('meninggal');
					$scope.data.showAyahMeninggal_TT1 = true;
					$scope.data.showAyahHidup_TT1 = false;
					$scope.data.showAyahHidupTidakSehat_TT1 = false;
				} else if ($scope.data.isAyahHidup_TT1 && typeof $scope.data.isAyahHidup_TT1 !== 'undefined') {
					console.log('hidup');
					$scope.data.showAyahMeninggal_TT1 = false;
					$scope.data.showAyahHidup_TT1 = true;
					
					if ($scope.data.isAyahHidupSehat_TT1 && typeof $scope.data.isAyahHidupSehat_TT1 !== 'undefined') { 
						console.log('sehat');
						$scope.data.showAyahHidupTidakSehat_TT1 = false;
					} else if (!$scope.data.isAyahHidupSehat_TT1 && typeof $scope.data.isAyahHidupSehat_TT1 !== 'undefined') { 
						console.log('sakit');
						$scope.data.showAyahHidupTidakSehat_TT1 = true;
					}
				}


				if (!$scope.data.isIbuHidup_TT1 && typeof $scope.data.isIbuHidup_TT1 !== 'undefined') {
					console.log('meninggal');
					$scope.data.showIbuMeninggal_TT1 = true;
					$scope.data.showIbuHidup_TT1 = false;
					$scope.data.showIbuHidupTidakSehat_TT1 = false;
				} else if ($scope.data.isIbuHidup_TT1 && typeof $scope.data.isIbuHidup_TT1 !== 'undefined') {
					console.log('hidup');
					$scope.data.showIbuMeninggal_TT1 = false;
					$scope.data.showIbuHidup_TT1 = true;
					
					if ($scope.data.isIbuHidupSehat_TT1 && typeof $scope.data.isIbuHidupSehat_TT1 !== 'undefined') { 
						console.log('sehat');
						$scope.data.showIbuHidupTidakSehat_TT1 = false;
					} else if (!$scope.data.isIbuHidupSehat_TT1 && typeof $scope.data.isIbuHidupSehat_TT1 !== 'undefined') { 
						console.log('sakit');
						$scope.data.showIbuHidupTidakSehat_TT1 = true;
					}
				}
				
				if (!$scope.data.isPasanganHidup_TT1 && typeof $scope.data.isPasanganHidup_TT1 !== 'undefined') {
					console.log('meninggal');
					$scope.data.showPasanganMeninggal_TT1 = true;
					$scope.data.showPasanganHidup_TT1 = false;
					$scope.data.showPasanganHidupTidakSehat_TT1 = false;
				} else if ($scope.data.isPasanganHidup_TT1 && typeof $scope.data.isPasanganHidup_TT1 !== 'undefined') {
					console.log('hidup');
					$scope.data.showPasanganMeninggal_TT1 = false;
					$scope.data.showPasanganHidup_TT1 = true;
					
					if ($scope.data.isPasanganHidupSehat_TT1 && typeof $scope.data.isPasanganHidupSehat_TT1 !== 'undefined') { 
						console.log('sehat');
						$scope.data.showPasanganHidupTidakSehat_TT1 = false;
					} else if (!$scope.data.isPasanganHidupSehat_TT1 && typeof $scope.data.isPasanganHidupSehat_TT1 !== 'undefined') { 
						console.log('sakit');
						$scope.data.showPasanganHidupTidakSehat_TT1 = true;
					}
				}
	

			}

			$store.set('SPAJ::' + $scope.data.spaj_guid + '::' + $formdata.pageId, $scope.data);
			spajProvider.setSpajElement($formdata);
			//$scope.showAlert('Test Display',angular.toJson(spajProvider.getSpajElement('aplikasiSPAJOnline.dataTertanggung23'), true));
		}

		$scope.init_data = function () {
			$scope.isHanya1tertanggung = false;
			$scope.isTertanggungTambahan = false;
			let initdate = new Date();

			$scope.data = {
				'spaj_guid': spajProvider.getSpajGUID(),
				'viewSKKas': '0',
				
				'jumlahAnakTTU':0,
				'jumlahAnakTT1':0,
				'jumlahAnakTT2':0,
				'jumlahAnakTT3':0,
				'jumlahAnakTT4':0,
				
				'isHobiAdaTTU': true,
				'isHobiAdaTT1': false,
				'isHobiAdaTT2': false,
				'isHobiAdaTT3': false,
				'isHobiAdaTT4': false,
				
				'hobbyTTU' : prospek.kdhobictt,
				
				'jenKelTTU': '0',
				'jenKelTT1': '0',
				'jenKelTT2': '0',
				'jenKelTT3': '0',
				'jenKelTT4': '0',
				'jenKelTT5': '0',
				
				'isSkkTertanggungAccepted': false,
				'isPenyakitTurunan': false,
				'jenisPenyakit': false,
				'isPenyakitDiderita': false,
				'isAdaTTU': true,
				'isAdaTT1': false,
				'isAdaTT2': false,
				'isAdaTT3': false,
				'isAdaTT4': false,
				
				'isPenyakit1': false,
				'isPenyakit1_TTU': false,
				'isPenyakit1_TT1': false,
				'isPenyakit1_TT2': false,
				'isPenyakit1_TT3': false,
				'isPenyakit1_TT4': false,
				'isPenyakit2': false,
				'isPenyakit2_TTU': false,
				'isPenyakit2_TT1': false,
				'isPenyakit2_TT2': false,
				'isPenyakit2_TT3': false,
				'isPenyakit2_TT4': false,
				'isPenyakit3': false,
				'isPenyakit3_TTU': false,
				'isPenyakit3_TT1': false,
				'isPenyakit3_TT2': false,
				'isPenyakit3_TT3': false,
				'isPenyakit3_TT4': false,
				'isPenyakit4': false,
				'isPenyakit4_TTU': false,
				'isPenyakit4_TT1': false,
				'isPenyakit4_TT2': false,
				'isPenyakit4_TT3': false,
				'isPenyakit4_TT4': false,
				'isPenyakit5': false,
				'isPenyakit5_TTU': false,
				'isPenyakit5_TT1': false,
				'isPenyakit5_TT2': false,
				'isPenyakit5_TT3': false,
				'isPenyakit5_TT4': false,
				'isPenyakit6': false,
				'isPenyakit6_TTU': false,
				'isPenyakit6_TT1': false,
				'isPenyakit6_TT2': false,
				'isPenyakit6_TT3': false,
				'isPenyakit6_TT4': false,
				'isPenyakit7': false,
				'isPenyakit7_TTU': false,
				'isPenyakit7_TT1': false,
				'isPenyakit7_TT2': false,
				'isPenyakit7_TT3': false,
				'isPenyakit7_TT4': false,
				'isPenyakit5': false,
				'isPenyakit5_TTU': false,
				'isPenyakit5_TT1': false,
				'isPenyakit5_TT2': false,
				'isPenyakit5_TT3': false,
				'isPenyakit5_TT4': false,
				'isPenyakit6': false,
				'isPenyakit6_TTU': false,
				'isPenyakit6_TT1': false,
				'isPenyakit6_TT2': false,
				'isPenyakit6_TT3': false,
				'isPenyakit6_TT4': false,
				'isPenyakit7': false,
				'isPenyakit7_TTU': false,
				'isPenyakit7_TT1': false,
				'isPenyakit7_TT2': false,
				'isPenyakit7_TT3': false,
				'isPenyakit7_TT4': false,
				'isPenyakit8': false,
				'isPenyakit8_TTU': false,
				'isPenyakit8_TT1': false,
				'isPenyakit8_TT2': false,
				'isPenyakit8_TT3': false,
				'isPenyakit8_TT4': false,
				'isPenyakit9': false,
				'isPenyakit9_TTU': false,
				'isPenyakit9_TT1': false,
				'isPenyakit9_TT2': false,
				'isPenyakit9_TT3': false,
				'isPenyakit9_TT4': false,
				'isPenyakit10': false,
				'isPenyakit10_TTU': false,
				'isPenyakit10_TT1': false,
				'isPenyakit10_TT2': false,
				'isPenyakit10_TT3': false,
				'isPenyakit10_TT4': false,
				'isPenyakit11': false,
				'isPenyakit11_TTU': false,
				'isPenyakit11_TT1': false,
				'isPenyakit11_TT2': false,
				'isPenyakit11_TT3': false,
				'isPenyakit11_TT4': false,
				'isPenyakit12': false,
				'isPenyakit12_TTU': false,
				'isPenyakit12_TT1': false,
				'isPenyakit12_TT2': false,
				'isPenyakit12_TT3': false,
				'isPenyakit12_TT4': false,
				'isPenyakit13': false,
				'isPenyakit13_TTU': false,
				'isPenyakit13_TT1': false,
				'isPenyakit13_TT2': false,
				'isPenyakit13_TT3': false,
				'isPenyakit13_TT4': false,
				'isPenyakit14': false,
				'isPenyakit14_TTU': false,
				'isPenyakit14_TT1': false,
				'isPenyakit14_TT2': false,
				'isPenyakit14_TT3': false,
				'isPenyakit14_TT4': false,
				'isPenyakit15': false,
				'isPenyakit15_TTU': false,
				'isPenyakit15_TT1': false,
				'isPenyakit15_TT2': false,
				'isPenyakit15_TT3': false,
				'isPenyakit15_TT4': false,
				'isPenyakit16': false,
				'isPenyakit16_TTU': false,
				'isPenyakit16_TT1': false,
				'isPenyakit16_TT2': false,
				'isPenyakit16_TT3': false,
				'isPenyakit16_TT4': false,
				'isPenyakit17': false,
				'jenisPenyakitLainnya': '',
				'isMerokok_TTU': false,
				'isMerokok_TT1': false,
				'isMerokok_TT2': false,
				'isMerokok_TT3': false,
				'isMerokok_TT4': false,
				'rokokBatangTTU': '',
				'rokokBatangTT1': '',
				'rokokBatangTT2': '',
				'rokokBatangTT3': '',
				'rokokBatangTT4': '',
				'isObat_TTU': false,
				'isObat_TT1': false,
				'isObat_TT2': false,
				'isObat_TT3': false,
				'isObat_TT4': false,
				'isWanitaPAP_TTU': false,
				'isWanitaPAP_TT1': false,
				'isWanitaPAP_TT2': false,
				'isWanitaPAP_TT3': false,
				'isWanitaPAP_TT4': false,
				'isMensTerganggu_TTU': false,
				'isMensTerganggu_TT1': false,
				'isMensTerganggu_TT2': false,
				'isMensTerganggu_TT3': false,
				'isMensTerganggu_TT4': false,
				'isMensTerganggu_TTU': false,
				'isMensTerganggu_TT1': false,
				'isMensTerganggu_TT2': false,
				'isMensTerganggu_TT3': false,
				'isMensTerganggu_TT4': false,
				'isCesar_TTU': false,
				'isCesar_TT1': false,
				'isCesar_TT2': false,
				'isCesar_TT3': false,
				'isCesar_TT4': false,
				'isKeguguran_TTU': false,
				'isKeguguran_TT1': false,
				'isKeguguran_TT2': false,
				'isKeguguran_TT3': false,
				'isKeguguran_TT4': false,
				'isKesulitanHamil_TTU': false,
				'isKesulitanHamil_TT1': false,
				'isKesulitanHamil_TT2': false,
				'isKesulitanHamil_TT3': false,
				'isKesulitanHamil_TT4': false,
				/* INI SKK UMUM */
				'umurAyahTTU': '',
				//'isAyahHidup_TTU':'',
				'showAyahMeninggal_TTU':false,
				'showAyahHidup_TTU':false,
				'showAyahHidupTidakSehat_TTU':false,
				'showAyahHidupTidakSehat_TT1':false,
				'showAyahHidupTidakSehat_TT2':false,
				'showAyahHidupTidakSehat_TT3':false,
				'showAyahHidupTidakSehat_TT4':false,
				//'isAyahHidupSehat_TTU':'',
				'isAyahDiabet_TTU': false,
				'isAyahHipertensi_TTU': false,
				'isAyahJantung_TTU': false,
				'isAyahTumor_TTU': false,
				'isAyahPenyakitKeturunan_TTU': false,
				'sebabMeninggalAyah_TTU': '',
				'lamaSakitAyah_TTU': '',
				//'tglMeninggalAyah_TTU': initdate.getFullYear(),
				'umurIbuTTU': '',

				'showIbuMeninggal_TTU':false,
				'showIbuHidup_TTU':false,
				'showIbuHidupTidakSehat_TTU':false,

				/** TT1 */
				'showIbuMeninggal_TT1':false,
				'showIbuHidup_TT1':false,
				'showIbuHidupTidakSehat_TT1':false,

				'isIbuMeninggal_TTU': false,
				'isIbuDiabet_TTU': false,
				'isIbuHipertensi_TTU': false,
				'isIbuJantung_TTU': false,
				'isIbuTumor_TTU': false,
				'isIbuPenyakitKeturunan_TTU': false,
				'sebabMeninggalIbu_TTU': '',
				'lamaSakitIbu_TTU': '',
				//'tglMeninggalIbu_TTU': initdate.getFullYear(),
				'umurPasanganTTU': '',


				'showPasanganMeninggal_TTU':false,
				'showPasanganHidup_TTU':false,
				'showPasanganHidupTidakSehat_TTU':false,

				/** TT1 */
				'showPasanganMeninggal_TT1':false,
				'showPasanganHidup_TT1':false,
				'showPasanganHidupTidakSehat_TT1':false,


				'isPasanganMeninggal_TTU': false,
				'isPasanganDiabet_TTU': false,
				'isPasanganHipertensi_TTU': false,
				'isPasanganJantung_TTU': false,
				'isPasanganTumor_TTU': false,
				'isPasanganPenyakitKeturunan_TTU': false,
				'sebabMeninggalPasangan_TTU': '',
				'lamaSakitPasangan_TTU': '',
				//'tglMeninggalPasangan_TTU': initdate.getFullYear(),
				'umurSaudaraLakiTTU': '',
				'isSaudaraLakiMeninggal_TTU': false,
				'isSaudaraLakiDiabet_TTU': false,
				'isSaudaraLakiHipertensi_TTU': false,
				'isSaudaraLakiJantung_TTU': false,
				'isSaudaraLakiTumor_TTU': false,
				'isSaudaraLakiPenyakitKeturunan_TTU': false,
				'lamaSakitSaudaraLaki_TTU': '',
				'sebabMeninggalSaudaraLaki_TTU': '',
				//'tglMeninggalSaudaraLaki_TTU': initdate.getFullYear(),
				'umurSaudaraPerempuanTTU': '',
				'isSaudaraPerempuanMeninggal_TTU': false,
				'isSaudaraPerempuanDiabet_TTU': false,
				'isSaudaraPerempuanHipertensi_TTU': false,
				'isSaudaraPerempuanJantung_TTU': false,
				'isSaudaraPerempuanTumor_TTU': false,
				'isSaudaraPerempuanPenyakitKeturunan_TTU': false,
				'sebabMeninggalSaudaraPerempuan_TTU': '',
				'lamaSakitSaudaraPerempuan_TTU': '',
				//'tglMeninggalSaudaraPerempuan_TTU': initdate.getFullYear(),
				'umurAnakTTU': '',
				'isAnakMeninggal_TTU': false,
				'isAnakDiabet_TTU': false,
				'isAnakHipertensi_TTU': false,
				'isAnakJantung_TTU': false,
				'isAnakTumor_TTU': false,
				'isAnakPenyakitKeturunan_TTU': false,
				'sebabMeninggalAnak_TTU': '',
				'lamaSakitAnak_TTU': '',
				//'tglMeninggalAnak_TTU': initdate.getFullYear(),
				'umurAyahTT1': '',
				'umurAyahTT2': '',
				'umurAyahTT3': '',
				'umurAyahTT4': '',

				/** Tertanggung TT1 */
				'isAyahMeninggal_TT1': false,
				'isAyahDiabet_TT1': false,
				'isAyahHipertensi_TT1': false,
				'isAyahJantung_TT1': false,
				'isAyahTumor_TT1': false,
				'isAyahPenyakitKeturunan_TT1': false,
				'sebabMeninggalAyah_TT1': '',
				'lamaSakitAyah_TT1': '',
				//'tglMeninggalAyah_TT1': initdate.getFullYear(),
				'umurIbuTT1': '',
				'isIbuMeninggal_TT1': false,
				'isIbuDiabet_TT1': false,
				'isIbuHipertensi_TT1': false,
				'isIbuJantung_TT1': false,
				'isIbuTumor_TT1': false,
				'isIbuPenyakitKeturunan_TT1': false,
				'sebabMeninggalIbu_TT1': '',
				'lamaSakitIbu_TT1': '',
				//'tglMeninggalIbu_TT1': initdate.getFullYear(),
				'umurPasanganTT1': '',
				'isPasanganMeninggal_TT1': false,
				'isPasanganDiabet_TT1': false,
				'isPasanganHipertensi_TT1': false,
				'isPasanganJantung_TT1': false,
				'isPasanganTumor_TT1': false,
				'isPasanganPenyakitKeturunan_TT1': false,
				'sebabMeninggalPasangan_TT1': '',
				'lamaSakitPasangan_TT1': '',
				//'tglMeninggalPasangan_TT1': initdate.getFullYear(),
				'umurSaudaraLakiTT1': '',
				'isSaudaraLakiMeninggal_TT1': false,
				'isSaudaraLakiDiabet_TT1': false,
				'isSaudaraLakiHipertensi_TT1': false,
				'isSaudaraLakiJantung_TT1': false,
				'isSaudaraLakiTumor_TT1': false,
				'isSaudaraLakiPenyakitKeturunan_TT1': false,
				'lamaSakitSaudaraLaki_TT1': '',
				'sebabMeninggalSaudaraLaki_TT1': '',
				'tglMeninggalSaudaraLaki_TT1': initdate.getFullYear(),
				'umurSaudaraPerempuanTT1': '',
				'isSaudaraPerempuanMeninggal_TT1': false,
				'isSaudaraPerempuanDiabet_TT1': false,
				'isSaudaraPerempuanHipertensi_TT1': false,
				'isSaudaraPerempuanJantung_TT1': false,
				'isSaudaraPerempuanTumor_TT1': false,
				'isSaudaraPerempuanPenyakitKeturunan_TT1': false,
				'sebabMeninggalSaudaraPerempuan_TT1': '',
				'lamaSakitSaudaraPerempuan_TT1': '',
				'tglMeninggalSaudaraPerempuan_TT1': initdate.getFullYear(),
				'umurAnakTT1': '',
				'isAnakMeninggal_TT1': false,
				'isAnakDiabet_TT1': false,
				'isAnakHipertensi_TT1': false,
				'isAnakJantung_TT1': false,
				'isAnakTumor_TT1': false,
				'isAnakPenyakitKeturunan_TT1': false,
				'sebabMeninggalAnak_TT1': '',
				'lamaSakitAnak_TT1': '',
				'tglMeninggalAnak_TT1': initdate.getFullYear(),

				/** Tertanggung TT2 */
				'isAyahMeninggal_TT2': false,
				'isAyahDiabet_TT2': false,
				'isAyahHipertensi_TT2': false,
				'isAyahJantung_TT2': false,
				'isAyahTumor_TT2': false,
				'isAyahPenyakitKeturunan_TT2': false,
				'sebabMeninggalAyah_TT2': '',
				'lamaSakitAyah_TT2': '',
				'tglMeninggalAyah_TT2': initdate.getFullYear(),
				'umurIbuTT2': '',
				'isIbuMeninggal_TT2': false,
				'isIbuDiabet_TT2': false,
				'isIbuHipertensi_TT2': false,
				'isIbuJantung_TT2': false,
				'isIbuTumor_TT2': false,
				'isIbuPenyakitKeturunan_TT2': false,
				'sebabMeninggalIbu_TT2': '',
				'lamaSakitIbu_TT2': '',
				'tglMeninggalIbu_TT2': initdate.getFullYear(),
				'umurPasanganTT2': '',
				'isPasanganMeninggal_TT2': false,
				'isPasanganDiabet_TT2': false,
				'isPasanganHipertensi_TT2': false,
				'isPasanganJantung_TT2': false,
				'isPasanganTumor_TT2': false,
				'isPasanganPenyakitKeturunan_TT2': false,
				'sebabMeninggalPasangan_TT2': '',
				'lamaSakitPasangan_TT2': '',
				'tglMeninggalPasangan_TT2': initdate.getFullYear(),
				'umurSaudaraLakiTT2': '',
				'isSaudaraLakiMeninggal_TT2': false,
				'isSaudaraLakiDiabet_TT2': false,
				'isSaudaraLakiHipertensi_TT2': false,
				'isSaudaraLakiJantung_TT2': false,
				'isSaudaraLakiTumor_TT2': false,
				'isSaudaraLakiPenyakitKeturunan_TT2': false,
				'lamaSakitSaudaraLaki_TT2': '',
				'sebabMeninggalSaudaraLaki_TT2': '',
				'tglMeninggalSaudaraLaki_TT2': initdate.getFullYear(),
				'umurSaudaraPerempuanTT2': '',
				'isSaudaraPerempuanMeninggal_TT2': false,
				'isSaudaraPerempuanDiabet_TT2': false,
				'isSaudaraPerempuanHipertensi_TT2': false,
				'isSaudaraPerempuanJantung_TT2': false,
				'isSaudaraPerempuanTumor_TT2': false,
				'isSaudaraPerempuanPenyakitKeturunan_TT2': false,
				'sebabMeninggalSaudaraPerempuan_TT2': '',
				'lamaSakitSaudaraPerempuan_TT2': '',
				'tglMeninggalSaudaraPerempuan_TT2': initdate.getFullYear(),
				'umurAnakTT2': '',
				'isAnakMeninggal_TT2': false,
				'isAnakDiabet_TT2': false,
				'isAnakHipertensi_TT2': false,
				'isAnakJantung_TT2': false,
				'isAnakTumor_TT2': false,
				'isAnakPenyakitKeturunan_TT2': false,
				'sebabMeninggalAnak_TT2': '',
				'lamaSakitAnak_TT2': '',
				'tglMeninggalAnak_TT2': initdate.getFullYear(),

				/** Tertanggung TT3 */
				'isAyahMeninggal_TT3': false,
				'isAyahDiabet_TT3': false,
				'isAyahHipertensi_TT3': false,
				'isAyahJantung_TT3': false,
				'isAyahTumor_TT3': false,
				'isAyahPenyakitKeturunan_TT3': false,
				'sebabMeninggalAyah_TT3': '',
				'lamaSakitAyah_TT3': '',
				'tglMeninggalAyah_TT3': initdate.getFullYear(),
				'umurIbuTT3': '',
				'isIbuMeninggal_TT3': false,
				'isIbuDiabet_TT3': false,
				'isIbuHipertensi_TT3': false,
				'isIbuJantung_TT3': false,
				'isIbuTumor_TT3': false,
				'isIbuPenyakitKeturunan_TT3': false,
				'sebabMeninggalIbu_TT3': '',
				'lamaSakitIbu_TT3': '',
				'tglMeninggalIbu_TT3': initdate.getFullYear(),
				'umurPasanganTT3': '',
				'isPasanganMeninggal_TT3': false,
				'isPasanganDiabet_TT3': false,
				'isPasanganHipertensi_TT3': false,
				'isPasanganJantung_TT3': false,
				'isPasanganTumor_TT3': false,
				'isPasanganPenyakitKeturunan_TT3': false,
				'sebabMeninggalPasangan_TT3': '',
				'lamaSakitPasangan_TT3': '',
				'tglMeninggalPasangan_TT3': initdate.getFullYear(),
				'umurSaudaraLakiTT3': '',
				'isSaudaraLakiMeninggal_TT3': false,
				'isSaudaraLakiDiabet_TT3': false,
				'isSaudaraLakiHipertensi_TT3': false,
				'isSaudaraLakiJantung_TT3': false,
				'isSaudaraLakiTumor_TT3': false,
				'isSaudaraLakiPenyakitKeturunan_TT3': false,
				'lamaSakitSaudaraLaki_TT3': '',
				'sebabMeninggalSaudaraLaki_TT3': '',
				'tglMeninggalSaudaraLaki_TT3': initdate.getFullYear(),
				'umurSaudaraPerempuanTT3': '',
				'isSaudaraPerempuanMeninggal_TT3': false,
				'isSaudaraPerempuanDiabet_TT3': false,
				'isSaudaraPerempuanHipertensi_TT3': false,
				'isSaudaraPerempuanJantung_TT3': false,
				'isSaudaraPerempuanTumor_TT3': false,
				'isSaudaraPerempuanPenyakitKeturunan_TT3': false,
				'sebabMeninggalSaudaraPerempuan_TT3': '',
				'lamaSakitSaudaraPerempuan_TT3': '',
				'tglMeninggalSaudaraPerempuan_TT3': initdate.getFullYear(),
				'umurAnakTT3': '',
				'isAnakMeninggal_TT3': false,
				'isAnakDiabet_TT3': false,
				'isAnakHipertensi_TT3': false,
				'isAnakJantung_TT3': false,
				'isAnakTumor_TT3': false,
				'isAnakPenyakitKeturunan_TT3': false,
				'sebabMeninggalAnak_TT3': '',
				'lamaSakitAnak_TT3': '',
				'tglMeninggalAnak_TT3': initdate.getFullYear(),


				/** Tertanggung TT4 */
				'isAyahMeninggal_TT4': false,
				'isAyahDiabet_TT4': false,
				'isAyahHipertensi_TT4': false,
				'isAyahJantung_TT4': false,
				'isAyahTumor_TT4': false,
				'isAyahPenyakitKeturunan_TT4': false,
				'sebabMeninggalAyah_TT4': '',
				'lamaSakitAyah_TT4': '',
				'tglMeninggalAyah_TT4': initdate.getFullYear(),
				'umurIbuTT4': '',
				'isIbuMeninggal_TT4': false,
				'isIbuDiabet_TT4': false,
				'isIbuHipertensi_TT4': false,
				'isIbuJantung_TT4': false,
				'isIbuTumor_TT4': false,
				'isIbuPenyakitKeturunan_TT4': false,
				'sebabMeninggalIbu_TT4': '',
				'lamaSakitIbu_TT4': '',
				'tglMeninggalIbu_TT4': initdate.getFullYear(),
				'umurPasanganTT4': '',
				'isPasanganMeninggal_TT4': false,
				'isPasanganDiabet_TT4': false,
				'isPasanganHipertensi_TT4': false,
				'isPasanganJantung_TT4': false,
				'isPasanganTumor_TT4': false,
				'isPasanganPenyakitKeturunan_TT4': false,
				'sebabMeninggalPasangan_TT4': '',
				'lamaSakitPasangan_TT4': '',
				'tglMeninggalPasangan_TT4': initdate.getFullYear(),
				'umurSaudaraLakiTT4': '',
				'isSaudaraLakiMeninggal_TT4': false,
				'isSaudaraLakiDiabet_TT4': false,
				'isSaudaraLakiHipertensi_TT4': false,
				'isSaudaraLakiJantung_TT4': false,
				'isSaudaraLakiTumor_TT4': false,
				'isSaudaraLakiPenyakitKeturunan_TT4': false,
				'lamaSakitSaudaraLaki_TT4': '',
				'sebabMeninggalSaudaraLaki_TT4': '',
				'tglMeninggalSaudaraLaki_TT4': initdate.getFullYear(),
				'umurSaudaraPerempuanTT4': '',
				'isSaudaraPerempuanMeninggal_TT4': false,
				'isSaudaraPerempuanDiabet_TT4': false,
				'isSaudaraPerempuanHipertensi_TT4': false,
				'isSaudaraPerempuanJantung_TT4': false,
				'isSaudaraPerempuanTumor_TT4': false,
				'isSaudaraPerempuanPenyakitKeturunan_TT4': false,
				'sebabMeninggalSaudaraPerempuan_TT4': '',
				'lamaSakitSaudaraPerempuan_TT4': '',
				'tglMeninggalSaudaraPerempuan_TT4': initdate.getFullYear(),
				'umurAnakTT4': '',
				'isAnakMeninggal_TT4': false,
				'isAnakDiabet_TT4': false,
				'isAnakHipertensi_TT4': false,
				'isAnakJantung_TT4': false,
				'isAnakTumor_TT4': false,
				'isAnakPenyakitKeturunan_TT4': false,
				'sebabMeninggalAnak_TT4': '',
				'lamaSakitAnak_TT4': '',
				'tglMeninggalAnak_TT4': initdate.getFullYear(),


				'isSehatTTU': false,
				'isSehatTT1': false,
				'isSehatTT2': false,
				'isGejalaTTU': true,
				'isGejalaTT1': false,
				'isGejalaTT2': false,

				/** TTU */
				'isPenyakitT01_TTU': false,
				'tglSakitT01_TTU': '',
				'namaDokterT01_TTU': '',
				'namaPenyakitT01_TTU' : '',

				/** TT1 */
				'isPenyakitT01_TT1': false,
				'tglSakitT01_TT1': '',
				'namaDokterT01_TT1': '',
				'namaPenyakitT01_TT1' : '',

				/** TT2 */
				'isPenyakitT01_TT2': false,
				'tglSakitT01_TT2': '',
				'namaDokterT01_TT2': '',
				'namaPenyakitT01_TT2' : '',

				/** TT3 */
				'isPenyakitT01_TT3': false,
				'tglSakitT01_TT3': '',
				'namaDokterT01_TT3': '',
				'namaPenyakitT01_TT3' : '',

				/** TT4 */
				'isPenyakitT01_TT4': false,
				'tglSakitT01_TT4': '',
				'namaDokterT01_TT4': '',
				'namaPenyakitT01_TT4' : '',

				/** TTu */
				'isPenyakitT02_TTU': false,
				'tglSakitT02_TTU': '',
				'namaDokterT02_TTU': '',
				'namaPenyakitT02_TTU' : '',

				/** TT1 */
				'isPenyakitT02_TT1': false,
				'tglSakitT02_TT1': '',
				'namaDokterT02_TT1': '',
				'namaPenyakitT02_TT1' : '',

				/** TT2 */
				'isPenyakitT02_TT2': false,
				'tglSakitT02_TT2': '',
				'namaDokterT02_TT2': '',
				'namaPenyakitT02_TT2' : '',

				/** TT3 */
				'isPenyakitT02_TT3': false,
				'tglSakitT02_TT3': '',
				'namaDokterT02_TT3': '',
				'namaPenyakitT02_TT3' : '',

				/** TT4 */
				'isPenyakitT02_TT4': false,
				'tglSakitT02_TT4': '',
				'namaDokterT02_TT4': '',
				'namaPenyakitT02_TT4' : '',

				/** TTu */
				'isPenyakitT03_TTU': false,
				'tglSakitT03_TTU': '',
				'namaDokterT03_TTU': '',
				'namaPenyakitT03_TTU' : '',

				/** TT1 */
				'isPenyakitT03_TT1': false,
				'tglSakitT03_TT1': '',
				'namaDokterT03_TT1': '',
				'namaPenyakitT03_TT1' : '',

				/** TT2 */
				'isPenyakitT03_TT2': false,
				'tglSakitT03_TT2': '',
				'namaDokterT03_TT2': '',
				'namaPenyakitT03_TT2' : '',

				/** TT3 */
				'isPenyakitT03_TT3': false,
				'tglSakitT03_TT3': '',
				'namaDokterT03_TT3': '',
				'namaPenyakitT03_TT3' : '',

				/** TT4 */
				'isPenyakitT03_TT4': false,
				'tglSakitT03_TT4': '',
				'namaDokterT03_TT4': '',
				'namaPenyakitT03_TT4' : '',

				/** TTu */
				'isPenyakitT04_TTU': false,
				'tglSakitT04_TTU': '',
				'namaDokterT04_TTU': '',
				'namaPenyakitT04_TTU' : '',

				/** TT1 */
				'isPenyakitT04_TT1': false,
				'tglSakitT04_TT1': '',
				'namaDokterT04_TT1': '',
				'namaPenyakitT04_TT1' : '',

				/** TT2 */
				'isPenyakitT04_TT2': false,
				'tglSakitT04_TT2': '',
				'namaDokterT04_TT2': '',
				'namaPenyakitT04_TT2' : '',

				/** TT3 */
				'isPenyakitT04_TT3': false,
				'tglSakitT04_TT3': '',
				'namaDokterT04_TT3': '',
				'namaPenyakitT04_TT3' : '',

				/** TT4 */
				'isPenyakitT04_TT4': false,
				'tglSakitT04_TT4': '',
				'namaDokterT04_TT4': '',
				'namaPenyakitT04_TT4' : '',

				/** TTu */
				'isPenyakitT05_TTU': false,
				'tglSakitT05_TTU': '',
				'namaDokterT05_TTU': '',
				'namaPenyakitT05_TTU' : '',

				/** TT1 */
				'isPenyakitT05_TT1': false,
				'tglSakitT05_TT1': '',
				'namaDokterT05_TT1': '',
				'namaPenyakitT05_TT1' : '',

				/** TT2 */
				'isPenyakitT05_TT2': false,
				'tglSakitT05_TT2': '',
				'namaDokterT05_TT2': '',
				'namaPenyakitT05_TT2' : '',

				/** TT3 */
				'isPenyakitT05_TT3': false,
				'tglSakitT05_TT3': '',
				'namaDokterT05_TT3': '',
				'namaPenyakitT05_TT3' : '',

				/** TT4 */
				'isPenyakitT05_TT4': false,
				'tglSakitT05_TT4': '',
				'namaDokterT05_TT4': '',
				'namaPenyakitT05_TT4' : '',

				/** TTU */
				'isPenyakitT06_TTU': false,
				'tglSakitT06_TTU': '',
				'namaDokterT06_TTU': '',
				'namaPenyakitT06_TTU' : '',

				/** TT1 */
				'isPenyakitT06_TT1': false,
				'tglSakitT06_TT1': '',
				'namaDokterT06_TT1': '',
				'namaPenyakitT06_TT1' : '',

				/** TT2 */
				'isPenyakitT06_TT2': false,
				'tglSakitT06_TT2': '',
				'namaDokterT06_TT2': '',
				'namaPenyakitT06_TT2' : '',

				/** TT3 */
				'isPenyakitT06_TT3': false,
				'tglSakitT06_TT3': '',
				'namaDokterT06_TT3': '',
				'namaPenyakitT06_TT3' : '',

				/** TT4 */
				'isPenyakitT06_TT4': false,
				'tglSakitT06_TT4': '',
				'namaDokterT06_TT4': '',
				'namaPenyakitT06_TT4' : '',

				/** TTU */
				'isPenyakitT07_TTU': false,
				'tglSakitT07_TTU': '',
				'namaDokterT07_TTU': '',
				'namaPenyakitT07_TTU' : '',

				/** TT1 */
				'isPenyakitT07_TT1': false,
				'tglSakitT07_TT1': '',
				'namaDokterT07_TT1': '',
				'namaPenyakitT07_TT1' : '',

				/** TT2 */
				'isPenyakitT07_TT2': false,
				'tglSakitT07_TT2': '',
				'namaDokterT07_TT2': '',
				'namaPenyakitT07_TT2' : '',

				/** TT3 */
				'isPenyakitT07_TT3': false,
				'tglSakitT07_TT3': '',
				'namaDokterT07_TT3': '',
				'namaPenyakitT07_TT3' : '',

				/** TT4 */
				'isPenyakitT07_TT4': false,
				'tglSakitT07_TT4': '',
				'namaDokterT07_TT4': '',
				'namaPenyakitT07_TT4' : '',

				/** TTU */
				'isPenyakitT08_TTU': false,
				'tglSakitT08_TTU': '',
				'namaDokterT08_TTU': '',
				'namaPenyakitT08_TTU' : '',

				/** TT1 */
				'isPenyakitT08_TT1': false,
				'tglSakitT08_TT1': '',
				'namaDokterT08_TT1': '',
				'namaPenyakitT08_TT1' : '',

				/** TT2 */
				'isPenyakitT08_TT2': false,
				'tglSakitT08_TT2': '',
				'namaDokterT08_TT2': '',
				'namaPenyakitT08_TT2' : '',

				/** TT3 */
				'isPenyakitT08_TT3': false,
				'tglSakitT08_TT3': '',
				'namaDokterT08_TT3': '',
				'namaPenyakitT08_TT3' : '',

				/** TT4 */
				'isPenyakitT08_TT4': false,
				'tglSakitT08_TT4': '',
				'namaDokterT08_TT4': '',
				'namaPenyakitT08_TT4' : '',

				/** TTU */
				'isPenyakitT09_TTU': false,
				'tglSakitT09_TTU': '',
				'namaDokterT09_TTU': '',
				'namaPenyakitT09_TTU' : '',

				/** TT1 */
				'isPenyakitT09_TT1': false,
				'tglSakitT09_TT1': '',
				'namaDokterT09_TT1': '',
				'namaPenyakitT09_TT1' : '',

				/** TT2 */
				'isPenyakitT09_TT2': false,
				'tglSakitT09_TT2': '',
				'namaDokterT09_TT2': '',
				'namaPenyakitT09_TT2' : '',

				/** TT3 */
				'isPenyakitT09_TT3': false,
				'tglSakitT09_TT3': '',
				'namaDokterT09_TT3': '',
				'namaPenyakitT09_TT3' : '',

				/** TT4 */
				'isPenyakitT09_TT4': false,
				'tglSakitT09_TT4': '',
				'namaDokterT09_TT4': '',
				'namaPenyakitT09_TT4' : '',

				/** TTU */
				'isPenyakitT10_TTU': false,
				'tglSakitT10_TTU': '',
				'namaDokterT10_TTU': '',
				'namaPenyakitT10_TTU' : '',

				/** TT1 */
				'isPenyakitT10_TT1': false,
				'tglSakitT10_TT1': '',
				'namaDokterT10_TT1': '',
				'namaPenyakitT10_TT1' : '',

				/** TT2 */
				'isPenyakitT10_TT2': false,
				'tglSakitT10_TT2': '',
				'namaDokterT10_TT2': '',
				'namaPenyakitT10_TT2' : '',

				/** TT3 */
				'isPenyakitT10_TT3': false,
				'tglSakitT10_TT3': '',
				'namaDokterT10_TT3': '',
				'namaPenyakitT10_TT3' : '',

				/** TT4 */
				'isPenyakitT10_TT4': false,
				'tglSakitT10_TT4': '',
				'namaDokterT10_TT4': '',
				'namaPenyakitT10_TT4' : '',

				/** TTU */
				'isPenyakitT11_TTU': false,
				'tglSakitT11_TTU': '',
				'namaDokterT11_TTU': '',
				'namaPenyakitT11_TTU' : '',

				/** TT1 */
				'isPenyakitT11_TT1': false,
				'tglSakitT11_TT1': '',
				'namaDokterT11_TT1': '',
				'namaPenyakitT11_TT1' : '',

				/** TT2 */
				'isPenyakitT11_TT2': false,
				'tglSakitT11_TT2': '',
				'namaDokterT11_TT2': '',
				'namaPenyakitT11_TT2' : '',

				/** TT3 */
				'isPenyakitT11_TT3': false,
				'tglSakitT11_TT3': '',
				'namaDokterT11_TT3': '',
				'namaPenyakitT11_TT3' : '',

				/** TT4 */
				'isPenyakitT11_TT4': false,
				'tglSakitT11_TT4': '',
				'namaDokterT11_TT4': '',
				'namaPenyakitT11_TT4' : '',

				/** TTU */
				'isPenyakitT12_TTU': false,
				'tglSakitT12_TTU': '',
				'namaDokterT12_TTU': '',
				'namaPenyakitT12_TTU' : '',

				/** TT1 */
				'isPenyakitT12_TT1': false,
				'tglSakitT12_TT1': '',
				'namaDokterT12_TT1': '',
				'namaPenyakitT12_TT1' : '',

				/** TT2 */
				'isPenyakitT12_TT2': false,
				'tglSakitT12_TT2': '',
				'namaDokterT12_TT2': '',
				'namaPenyakitT12_TT2' : '',

				/** TT3 */
				'isPenyakitT12_TT3': false,
				'tglSakitT12_TT3': '',
				'namaDokterT12_TT3': '',
				'namaPenyakitT12_TT3' : '',

				/** TT4 */
				'isPenyakitT12_TT4': false,
				'tglSakitT12_TT4': '',
				'namaDokterT12_TT4': '',
				'namaPenyakitT12_TT4' : '',

				/** TTU */
				'isPenyakitT13_TTU': false,
				'tglSakitT13_TTU': '',
				'namaDokterT13_TTU': '',
				'namaPenyakitT13_TTU' : '',

				/** TT1 */
				'isPenyakitT13_TT1': false,
				'tglSakitT13_TT1': '',
				'namaDokterT13_TT1': '',
				'namaPenyakitT13_TT1' : '',

				/** TT2 */
				'isPenyakitT13_TT2': false,
				'tglSakitT13_TT2': '',
				'namaDokterT13_TT2': '',
				'namaPenyakitT13_TT2' : '',

				/** TT3 */
				'isPenyakitT13_TT3': false,
				'tglSakitT13_TT3': '',
				'namaDokterT13_TT3': '',
				'namaPenyakitT13_TT3' : '',

				/** TT4 */
				'isPenyakitT13_TT4': false,
				'tglSakitT13_TT4': '',
				'namaDokterT13_TT4': '',
				'namaPenyakitT13_TT4' : '',

				/** TTu */
				'isPenyakitT14_TTU': false,
				'tglSakitT14_TTU': '',
				'namaDokterT14_TTU': '',
				'namaPenyakitT14_TTU' : '',

				/** TT1 */
				'isPenyakitT14_TT1': false,
				'tglSakitT14_TT1': '',
				'namaDokterT14_TT1': '',
				'namaPenyakitT14_TT1' : '',

				/** TT2 */
				'isPenyakitT14_TT2': false,
				'tglSakitT14_TT2': '',
				'namaDokterT14_TT2': '',
				'namaPenyakitT14_TT2' : '',

				/** TT3 */
				'isPenyakitT14_TT3': false,
				'tglSakitT14_TT3': '',
				'namaDokterT14_TT3': '',
				'namaPenyakitT14_TT3' : '',

				/** TT4 */
				'isPenyakitT14_TT4': false,
				'tglSakitT14_TT4': '',
				'namaDokterT14_TT4': '',
				'namaPenyakitT14_TT4' : '',

				/** TTU */
				'isPenyakitT15_TTU': false,
				'tglSakitT15_TTU': '',
				'namaDokterT15_TTU': '',
				'namaPenyakitT15_TTU' : '',

				/** TT1 */
				'isPenyakitT15_TT1': false,
				'tglSakitT15_TT1': '',
				'namaDokterT15_TT1': '',
				'namaPenyakitT15_TT1' : '',

				/** TT2 */
				'isPenyakitT15_TT2': false,
				'tglSakitT15_TT2': '',
				'namaDokterT15_TT2': '',
				'namaPenyakitT15_TT2' : '',

				/** TT3 */
				'isPenyakitT15_TT3': false,
				'tglSakitT15_TT3': '',
				'namaDokterT15_TT3': '',
				'namaPenyakitT15_TT3' : '',

				/** TT4 */
				'isPenyakitT15_TT4': false,
				'tglSakitT15_TT4': '',
				'namaDokterT15_TT4': '',
				'namaPenyakitT15_TT4' : '',

				/** TTU */
				'isPenyakitT16_TTU': false,
				'tglSakitT16_TTU': '',
				'namaDokterT16_TTU': '',
				'namaPenyakitT16_TTU' : '',

				/** TT1 */
				'isPenyakitT16_TT1': false,
				'tglSakitT16_TT1': '',
				'namaDokterT16_TT1': '',
				'namaPenyakitT16_TT1' : '',

				/** TT2 */
				'isPenyakitT16_TT2': false,
				'tglSakitT16_TT2': '',
				'namaDokterT16_TT2': '',
				'namaPenyakitT16_TT2' : '',

				/** TT3 */
				'isPenyakitT16_TT3': false,
				'tglSakitT16_TT3': '',
				'namaDokterT16_TT3': '',
				'namaPenyakitT16_TT3' : '',

				/** TT4 */
				'isPenyakitT16_TT4': false,
				'tglSakitT16_TT4': '',
				'namaDokterT16_TT4': '',
				'namaPenyakitT16_TT4' : '',

				/** TTU */
				'isPenyakitT17_TTU': false,
				'tglSakitT17_TTU': '',
				'namaDokterT17_TTU': '',
				'namaPenyakitT17_TTU' : '',

				/** TT1 */
				'isPenyakitT17_TT1': false,
				'tglSakitT17_TT1': '',
				'namaDokterT17_TT1': '',
				'namaPenyakitT17_TT1' : '',

				/** TT2 */
				'isPenyakitT17_TT2': false,
				'tglSakitT17_TT2': '',
				'namaDokterT17_TT2': '',
				'namaPenyakitT17_TT2' : '',

				/** TT3 */
				'isPenyakitT17_TT3': false,
				'tglSakitT17_TT3': '',
				'namaDokterT17_TT3': '',
				'namaPenyakitT17_TT3' : '',

				/** TT4 */
				'isPenyakitT17_TT4': false,
				'tglSakitT17_TT4': '',
				'namaDokterT17_TT4': '',
				'namaPenyakitT17_TT4' : '',

				/** TTU */
				'isPenyakitT18_TTU': false,
				'tglSakitT18_TTU': '',
				'namaDokterT18_TTU': '',
				'namaPenyakitT18_TTU' : '',

				/** TT1 */
				'isPenyakitT18_TT1': false,
				'tglSakitT18_TT1': '',
				'namaDokterT18_TT1': '',
				'namaPenyakitT18_TT1' : '',

				/** TT2 */
				'isPenyakitT18_TT2': false,
				'tglSakitT18_TT2': '',
				'namaDokterT18_TT2': '',
				'namaPenyakitT18_TT2' : '',

				/** TT3 */
				'isPenyakitT18_TT3': false,
				'tglSakitT18_TT3': '',
				'namaDokterT18_TT3': '',
				'namaPenyakitT18_TT3' : '',

				/** TT4 */
				'isPenyakitT18_TT4': false,
				'tglSakitT18_TT4': '',
				'namaDokterT18_TT4': '',
				'namaPenyakitT18_TT4' : '',

				/** TTU */
				'isPenyakitT19_TTU': false,
				'tglSakitT19_TTU': '',
				'namaDokterT19_TTU': '',
				'namaPenyakitT19_TTU' : '',

				/** TT1 */
				'isPenyakitT19_TT1': false,
				'tglSakitT19_TT1': '',
				'namaDokterT19_TT1': '',
				'namaPenyakitT19_TT1' : '',

				/** TT2 */
				'isPenyakitT19_TT2': false,
				'tglSakitT19_TT2': '',
				'namaDokterT19_TT2': '',
				'namaPenyakitT19_TT2' : '',

				/** TT3 */
				'isPenyakitT19_TT3': false,
				'tglSakitT19_TT3': '',
				'namaDokterT19_TT3': '',
				'namaPenyakitT19_TT3' : '',

				/** TT4 */
				'isPenyakitT19_TT4': false,
				'tglSakitT19_TT4': '',
				'namaDokterT19_TT4': '',
				'namaPenyakitT19_TT4' : '',

				/** TTU */
				'isPenyakitT20_TTU': false,
				'tglSakitT20_TTU': '',
				'namaDokterT20_TTU': '',
				'namaPenyakitT20_TTU' : '',

				/** TT1 */
				'isPenyakitT20_TT1': false,
				'tglSakitT20_TT1': '',
				'namaDokterT20_TT1': '',
				'namaPenyakitT20_TT1' : '',

				/** TT2 */
				'isPenyakitT20_TT2': false,
				'tglSakitT20_TT2': '',
				'namaDokterT20_TT2': '',
				'namaPenyakitT20_TT2' : '',

				/** TT3 */
				'isPenyakitT20_TT3': false,
				'tglSakitT20_TT3': '',
				'namaDokterT20_TT3': '',
				'namaPenyakitT20_TT3' : '',

				/** TT4 */
				'isPenyakitT20_TT4': false,
				'tglSakitT20_TT4': '',
				'namaDokterT20_TT4': '',
				'namaPenyakitT20_TT4' : '',


				'isSKKLengkap':false,
				'jumlahSaudaraKandungLakiTTU':0,
				'jumlahSaudaraKandungLakiTT1':0,
				'jumlahSaudaraKandungLakiTT2':0,
				'jumlahSaudaraKandungLakiTT3':0,
				'jumlahSaudaraKandungLakiTT4':0,
				'umurSaudaraLkTTU':[],
				'umurSaudaraLkTT1':[],
				'umurSaudaraLkTT2':[],
				'umurSaudaraLkTT3':[],
				'umurSaudaraLkTT4':[],
				'isHidupSaudaraLkTTU':[],
				'isHidupSaudaraLkTT1':[],
				'isHidupSaudaraLkTT2':[],
				'isHidupSaudaraLkTT3':[],
				'isHidupSaudaraLkTT4':[],
				'isSehatSaudaraLkTTU':[],
				'isSehatSaudaraLkTT1':[],
				'isSehatSaudaraLkTT2':[],
				'isSehatSaudaraLkTT3':[],
				'isSehatSaudaraLkTT4':[],				
				'jumlahSaudaraKandungPerempuanTTU':0,
				'jumlahSaudaraKandungPerempuanTT1':0,
				'jumlahSaudaraKandungPerempuanTT2':0,
				'jumlahSaudaraKandungPerempuanTT3':0,
				'jumlahSaudaraKandungPerempuanTT4':0,
				'umurSaudaraPrTTU':[],
				'umurSaudaraPrTT1':[],
				'umurSaudaraPrTT2':[],
				'umurSaudaraPrTT3':[],
				'umurSaudaraPrTT4':[],
				'isHidupSaudaraPrTTU':[],
				'isHidupSaudaraPrTT1':[],
				'isHidupSaudaraPrTT2':[],
				'isHidupSaudaraPrTT3':[],
				'isHidupSaudaraPrTT4':[],
				'isSehatSaudaraPrTTU':[],
				'isSehatSaudaraPrTT1':[],
				'isSehatSaudaraPrTT2':[],
				'isSehatSaudaraPrTT3':[],
				'isSehatSaudaraPrTT4':[],

				'isMataCacat__TTU' : '',
				'isMataCacat__TT1' : '',
				'isKakiCacat__TTU' : '',
				'isKakiCacat__TT1' : '',
				'isTanganCacat__TTU' : '',
				'isTanganCacat__TT1' : '',

			}
			
			if ($store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + $scope.pageId) == null) {} else {
				$scope.data = $store.get('SPAJ::' + spajProvider.getSpajGUID() + '::' + $scope.pageId);
				try{
					for (i = 0; i = $scope.data.jumlahSaudaraKandungLakiTTU < i; i++) {
					  $scope.data.umurSaudaraLkTTU[i.toString()] = $scope.data.umurSaudaraLkTTU[i];
					}					
					for (i = 0; i = $scope.data.jumlahSaudaraKandungLakiTTU < i; i++) {
					  $scope.data.isHidupSaudaraLkTTU[i.toString()] = $scope.data.isHidupSaudaraLkTTU[i];
					}					
					for (i = 0; i = $scope.data.jumlahSaudaraKandungLakiTTU < i; i++) { 
					  $scope.data.isSehatSaudaraLkTTU[i.toString()] = $scope.data.isSehatSaudaraLkTTU[i];
					}
					for (i = 0; i = $scope.data.jumlahSaudaraKandungPerempuanTTU < i; i++) {
					  $scope.data.umurSaudaraPrTTU[i.toString()] = $scope.data.umurSaudaraPrTTU[i];
					}					
					for (i = 0; i = $scope.data.jumlahSaudaraKandungPerempuanTTU < i; i++) {
					  $scope.data.isHidupSaudaraPrTTU[i.toString()] = $scope.data.isHidupSaudaraPrTTU[i];
					}					
					for (i = 0; i = $scope.data.jumlahSaudaraKandungPerempuanTTU < i; i++) { 
					  $scope.data.isSehatSaudaraPrTTU[i.toString()] = $scope.data.isSehatSaudaraPrTTU[i];
					}
				}catch(e){
					console.log(e);
				}

			}
		}
		
		$scope.$on('$ionicView.enter', function () {})
		$scope.validateThisFormOnPageAccept = function () {
			$scope.messages = [];
			try {
				if ($scope.data == null) {
					$scope.messages.push({
						"message": "Data ERROR. Null data."
					});
				}
			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}

			try{

				// console.log($scope.data.viewSKKas);
				// console.log($scope.isTertanggungTambahan);
				console.log('skk ini bos')
				console.log($scope.data.isMataCacat_TTU);
				console.log($scope.data.isKakiCacat_TTU);
				console.log($scope.data.isTanganCacat_TTU);
				console.log($scope.data.isMataCacat__TT1)

				/** Pasangan */
				
				if($scope.data.isPenyakitanOrtuTTU == null){
					$scope.messages.push({
						'message': "Surat Kesehatan tertanggung masih kosong!"
					});
				}

				if($scope.data.isPenyakitanOrtuTTU != null){
					/** AYAH */
					if ($scope.data.umurAyahTTU == '' || $scope.data.umurAyahTTU == 0 || $scope.data.umurAyahTTU == null) {
						$scope.messages.push({
							'message': "Umur Ayah Tertanggung Utama harus diisi!"
						});
					}

					if($scope.data.umurAyahTTU != null || $scope.data.umurAyahTTU != '' || $scope.data.umurAyahTTU != 0 ){
						if($scope.data.umurAyahTTU <= 17){
							$scope.messages.push({
								'message': "Silahkan isi dengan benar umur ayah tertanggung! (Harus diatas 17 tahun)"
							});
						}
					}

					if($scope.data.isAyahHidup_TTU == null){
						$scope.messages.push({
							'message': "Silahkan pilih Masih hidup/ Sudah meninggal ayah tertanggung!"
						});
					}

					if($scope.data.isAyahHidup_TTU){
						if($scope.data.isAyahHidupSehat_TTU == null){
							$scope.messages.push({
								'message': "Silahkan pilih salah satu keadaan ayah tertanggung!"
							});
						}

						if($scope.data.isAyahHidupSehat_TTU != null && !($scope.data.isAyahHidupSehat_TTU)){
							if (!($scope.data.isAyahDiabet_TTU || $scope.data.isAyahHipertensi_TTU || $scope.data.isAyahJantung_TTU || $scope.data.isAyahTumor_TTU || $scope.data.isAyahPenyakitKeturunan_TTU)) {
								$scope.messages.push({
									'message': "Silahkan pilih salah satu jenis penyakit Ayah Tertanggung!"
								});
							}
						}
					}
					if($scope.data.isAyahHidup_TTU != null){
						if(!($scope.data.isAyahHidup_TTU)){
							if($scope.data.sebabMeninggalAyah_TTU == ''){
								$scope.messages.push({
									'message': "penyebab meninggal ayah tertanggung, masih kosong!"
								});
							}
	
							if($scope.data.lamaSakitAyah_TTU == ''){
								$scope.messages.push({
									'message': "lama sakit ayah tertanggung, masih kosong!"
								});
							}
	
							if($scope.data.tglMeninggalAyah_TTU == '' || $scope.data.tglMeninggalAyah_TTU == null){
								$scope.messages.push({
									'message': "tanggal meninggal masih kosong!"
								});
							}
						}
					}
					/** END AYAH */

					/** IBU */
					if ($scope.data.umurIbuTTU == '' || $scope.data.umurIbuTTU == 0 || $scope.data.umurIbuTTU == null) {
						$scope.messages.push({
							'message': "Umur Ibu Tertanggung Utama harus diisi!"
						});
					}

					if ($scope.data.umurIbuTTU != '' || $scope.data.umurIbuTTU != 0 || $scope.data.umurIbuTTU != null) {
						if($scope.data.umurIbuTTU <= 17){
							$scope.messages.push({
								'message': "Silahkan isi dengan benar umur Ibu tertanggung! (Harus diatas 17 tahun)"
							});
						}
					}

					if($scope.data.isIbuHidup_TTU == null){
						$scope.messages.push({
							'message': "Silahkan pilih status keadaan Ibu tertanggung!"
						});
					}

					/** Jika Ibu Tertanggung Utama sudah meninggal dunia */
					if($scope.data.isIbuHidup_TTU != null){
						if(!($scope.data.isIbuHidup_TTU)){
	
							if($scope.data.sebabMeninggalIbu_TTU == ''){
								$scope.messages.push({
									'message': "penyebab meninggal Ibu tertanggung, masih kosong!"
								});
							}
	
							if($scope.data.lamaSakitIbu_TTU == ''){
								$scope.messages.push({
									'message': "lama sakit Ibu tertanggung, masih kosong!"
								});
							}
	
							if($scope.data.tglMeninggalIbu_TTU == ''){
								$scope.messages.push({
									'message': "tanggal meninggal masih kosong!"
								});
							}
						}
					}

					/** Jika Ibu tertanggung utama masih hidup */
					if($scope.data.isIbuHidup_TTU){

						/** Jika pilihan Sehat/ Tidak Sehat masih kosong */
						if($scope.data.isIbuHidupSehat_TTU == null){
							$scope.messages.push({
								'message': "Silahkan pilih salah satu keadaan Ibu tertanggung!"
							});
						}

						/** Jika memlilih tidak sehat, dan jenis penyakit belum di pilih */
						if($scope.data.isIbuHidupSehat_TTU != null && !($scope.data.isIbuHidupSehat_TTU)){
							if (!($scope.data.isIbuDiabet_TTU || $scope.data.isIbuHipertensi_TTU || $scope.data.isIbuJantung_TTU || $scope.data.isIbuTumor_TTU || $scope.data.isIbuPenyakitKeturunan_TTU)) {
								$scope.messages.push({
									'message': "Silahkan pilih salah satu jenis penyakit Ibu Tertanggung!"
								});
							}
						}
					}
					
					/** END Ibu */
				}

				if($scope.data.isPenyakitanKeluargaTTU == null){
					$scope.messages.push({
						'message': "Silahkan pilih, Ya/Tidak ada keluarga yang sakit!"
					});
				}

				if($scope.data.isPenyakitanKeluargaTTU){

					if($scope.data.isAdaPasangan_TTU == null){
						console.log('iya ini null')
						$scope.messages.push({
							'message': "pilihan status pasangan masih kosong!"
						});
					}
	
					if($scope.data.isAdaPasangan_TTU){
						if($scope.data.umurPasanganTTU == ''){
							$scope.messages.push({
								'message': "Umur pasangan tertanggung masih kosong!"
							});
						}
	
						if($scope.data.isPasanganHidup_TTU == null){
							$scope.messages.push({
								'message': "Status keadaan hidup/meninggal pasangan masih kosong!"
							});
						}
	
						if($scope.data.isPasanganHidup_TTU){
							if($scope.data.isPasanganHidupSehat_TTU == null){
								$scope.messages.push({
									'message': "Keadaan sehat/tidak sehat pasangan masih kosong!"
								});
							}
	
							if($scope.data.isPasanganHidupSehat_TTU != null && !($scope.data.isPasanganHidupSehat_TTU)){
								if(!($scope.data.isPasanganDiabet_TTU || $scope.data.isPasanganHipertensi_TTU || $scope.data.isPasanganJantung_TTU || $scope.data.isPasanganTumor_TTU || $scope.data.isPasanganPenyakitKeturunan_TTU)){
									$scope.messages.push({
										'message': "Silahkan pilih salah satu jenis penyakit Pasangan!"
									});
								}
							}
						}else{
							if($scope.data.sebabMeninggalPasangan_TTU == ''){
								$scope.messages.push({
									'message': "penyebab meninggal Pasangan tertanggung, masih kosong!"
								});
							}
		
							if($scope.data.lamaSakitPasangan_TTU == ''){
								$scope.messages.push({
									'message': "lama sakit Pasangan tertanggung, masih kosong!"
								});
							}
		
							if($scope.data.tglMeninggalPasangan_TTU == ''){
								$scope.messages.push({
									'message': "tanggal meninggal pasangan tertanggung masih kosong!"
								});
							}
						}
	
						if($scope.data.tglMenikahTTU == '' || $scope.data.tglMenikahTTU == null){
							$scope.messages.push({
								'message': "tanggal menikah pasangan tertanggung masih kosong!"
							});
						}
	
					}
	
					if($scope.data.jumlahAnakTTU == 1){
						if($scope.data.umurAnakTTU['0'] == null){
							$scope.messages.push({
								'message': "Usia anak pertama tertanggung masih kosong!"
							});
						}
	
					}
	
					if($scope.data.jumlahAnakTTU == 2){
						if($scope.data.umurAnakTTU['0'] == null){
							$scope.messages.push({
								'message': "Usia anak pertama tertanggung masih kosong!"
							});
						}
	
						if($scope.data.umurAnakTTU['1'] == null){
							$scope.messages.push({
								'message': "Usia anak kedua tertanggung masih kosong!"
							});
						}
	
					}
	
					if($scope.data.jumlahAnakTTU == 3){
						if($scope.data.umurAnakTTU['0'] == null){
							$scope.messages.push({
								'message': "Usia anak pertama tertanggung masih kosong!"
							});
						}
						
						if($scope.data.umurAnakTTU['1'] == null){
							$scope.messages.push({
								'message': "Usia anak kedua tertanggung masih kosong!"
							});
						}
	
						if($scope.data.umurAnakTTU['2'] == null){
							$scope.messages.push({
								'message': "Usia anak ketiga tertanggung masih kosong!"
							});
						}
	
					}
	
					if($scope.data.jumlahAnakTTU == 4){
						if($scope.data.umurAnakTTU['0'] == null){
							$scope.messages.push({
								'message': "Usia anak pertama tertanggung masih kosong!"
							});
						}
						
						if($scope.data.umurAnakTTU['1'] == null){
							$scope.messages.push({
								'message': "Usia anak kedua tertanggung masih kosong!"
							});
						}
						
						if($scope.data.umurAnakTTU['2'] == null){
							$scope.messages.push({
								'message': "Usia anak ketiga tertanggung masih kosong!"
							});
						}
	
						if($scope.data.umurAnakTTU['3'] == null){
							$scope.messages.push({
								'message': "Usia anak keempat tertanggung masih kosong!"
							});
						}
	
					}
	
					if($scope.data.jumlahAnakTTU == 5){
						if($scope.data.umurAnakTTU['0'] == null){
							$scope.messages.push({
								'message': "Usia anak pertama tertanggung masih kosong!"
							});
						}
						
						if($scope.data.umurAnakTTU['1'] == null){
							$scope.messages.push({
								'message': "Usia anak kedua tertanggung masih kosong!"
							});
						}
						
						if($scope.data.umurAnakTTU['2'] == null){
							$scope.messages.push({
								'message': "Usia anak ketiga tertanggung masih kosong!"
							});
						}
						
						if($scope.data.umurAnakTTU['3'] == null){
							$scope.messages.push({
								'message': "Usia anak keempat tertanggung masih kosong!"
							});
						}
	
						if($scope.data.umurAnakTTU['4'] == null){
							$scope.messages.push({
								'message': "Usia anak kelima tertanggung masih kosong!"
							});
						}
	
					}
	
					if($scope.data.jumlahSaudaraKandungLakiTTU == 1){
						if($scope.data.umurSaudaraLkTTU['0'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung laki - laki pertama tertanggung masih kosong!"
							});
						}
					}
	
					if($scope.data.jumlahSaudaraKandungLakiTTU == 2){
						if($scope.data.umurSaudaraLkTTU['0'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung laki - laki pertama tertanggung masih kosong!"
							});
						}
	
						if($scope.data.umurSaudaraLkTTU['1'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung laki - laki kedua tertanggung masih kosong!"
							});
						}
					}
	
					if($scope.data.jumlahSaudaraKandungLakiTTU == 3){
						if($scope.data.umurSaudaraLkTTU['0'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung laki - laki pertama tertanggung masih kosong!"
							});
						}
						
						if($scope.data.umurSaudaraLkTTU['1'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung laki - laki kedua tertanggung masih kosong!"
							});
						}
	
						if($scope.data.umurSaudaraLkTTU['2'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung laki - laki ketiga tertanggung masih kosong!"
							});
						}
					}
	
					if($scope.data.jumlahSaudaraKandungLakiTTU == 4){
						if($scope.data.umurSaudaraLkTTU['0'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung laki - laki pertama tertanggung masih kosong!"
							});
						}
						
						if($scope.data.umurSaudaraLkTTU['1'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung laki - laki kedua tertanggung masih kosong!"
							});
						}
						
						if($scope.data.umurSaudaraLkTTU['2'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung laki - laki ketiga tertanggung masih kosong!"
							});
						}
	
						if($scope.data.umurSaudaraLkTTU['3'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung laki - laki keempat tertanggung masih kosong!"
							});
						}
					}
	
					if($scope.data.jumlahSaudaraKandungLakiTTU == 5){
						if($scope.data.umurSaudaraLkTTU['0'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung laki - laki pertama tertanggung masih kosong!"
							});
						}
						
						if($scope.data.umurSaudaraLkTTU['1'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung laki - laki kedua tertanggung masih kosong!"
							});
						}
						
						if($scope.data.umurSaudaraLkTTU['2'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung laki - laki ketiga tertanggung masih kosong!"
							});
						}
						
						if($scope.data.umurSaudaraLkTTU['3'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung laki - laki keempat tertanggung masih kosong!"
							});
						}
	
						if($scope.data.umurSaudaraLkTTU['4'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung laki - laki kelima tertanggung masih kosong!"
							});
						}
					}
	
					if($scope.data.jumlahSaudaraKandungPerempuanTTU == 1){
						if($scope.data.umurSaudaraPrTTU['0'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung perempuan pertama tertanggung masih kosong!"
							});
						}
					}
	
					if($scope.data.jumlahSaudaraKandungPerempuanTTU == 2){
						if($scope.data.umurSaudaraPrTTU['0'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung perempuan pertama tertanggung masih kosong!"
							});
						}
						if($scope.data.umurSaudaraPrTTU['1'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung perempuan kedua tertanggung masih kosong!"
							});
						}
					}
	
					if($scope.data.jumlahSaudaraKandungPerempuanTTU == 3){
						if($scope.data.umurSaudaraPrTTU['0'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung perempuan pertama tertanggung masih kosong!"
							});
						}
						if($scope.data.umurSaudaraPrTTU['1'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung perempuan kedua tertanggung masih kosong!"
							});
						}
						if($scope.data.umurSaudaraPrTTU['2'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung perempuan ketiga tertanggung masih kosong!"
							});
						}
					}
	
					if($scope.data.jumlahSaudaraKandungPerempuanTTU == 4){
						if($scope.data.umurSaudaraPrTTU['0'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung perempuan pertama tertanggung masih kosong!"
							});
						}
						if($scope.data.umurSaudaraPrTTU['1'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung perempuan kedua tertanggung masih kosong!"
							});
						}
						if($scope.data.umurSaudaraPrTTU['2'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung perempuan ketiga tertanggung masih kosong!"
							});
						}
						if($scope.data.umurSaudaraPrTTU['3'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung perempuan keempat tertanggung masih kosong!"
							});
						}
					}
	
					if($scope.data.jumlahSaudaraKandungPerempuanTTU == 5){
						if($scope.data.umurSaudaraPrTTU['0'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung perempuan pertama tertanggung masih kosong!"
							});
						}
						if($scope.data.umurSaudaraPrTTU['1'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung perempuan kedua tertanggung masih kosong!"
							});
						}
						if($scope.data.umurSaudaraPrTTU['2'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung perempuan ketiga tertanggung masih kosong!"
							});
						}
						if($scope.data.umurSaudaraPrTTU['3'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung perempuan keempat tertanggung masih kosong!"
							});
						}
						if($scope.data.umurSaudaraPrTTU['4'] == null){
							$scope.messages.push({
								'message': "Usia Saudara kandung perempuan kelima tertanggung masih kosong!"
							});
						}
					}

				}

				if($scope.data.isSehatTTU == null){
					$scope.messages.push({
						'message': "Status kesehatan tertanggung utama masih kosong!"
					});	
				}

				if($scope.data.isSehatTTU != null){
					if(!($scope.data.isSehatTTU)){
						if($scope.data.alasanSakitTTU == null || $scope.data.alasanSakitTTU == ''){
							$scope.messages.push({
								'message': "Alasan Sakit tertanggung utama masih kosong!"
							});	
						}
					}
				}

				if($scope.data.isPekerjaanBaikTTU == null){
					$scope.messages.push({
						'message': "Silahkan pilih, Ya/Tidak dalam hal melakukan pekerjaan anda!" 
					});
				}

				if($scope.data.isPekerjaanBaikTTU != null && !($scope.data.isPekerjaanBaikTTU)){
					if($scope.data.alasanPekerjaanBaikTTU == null || $scope.data.alasanPekerjaanBaikTTU == ''){
						$scope.messages.push({
							'message': "Alasan Tidak melakukan Pekerjaan dengan baik tertanggung utama masih kosong!"
						});	
					}
				}

				if($scope.data.isGejalaTTU == null){
					$scope.messages.push({
						'message': "Silahkan pilih, Ya/Tidak dalam hal gejala gejala yang di derita!"
					});
				}

				if($scope.data.isGejalaTTU){
					console.log($scope.data.isPenyakitT01_TTU)
					if(!($scope.data.isPenyakitT01_TTU || $scope.data.isPenyakitT02_TTU || $scope.data.isPenyakitT03_TTU  || $scope.data.isPenyakitT04_TTU  || $scope.data.isPenyakitT05_TTU  || $scope.data.isPenyakitT06_TTU  || $scope.data.isPenyakitT07_TTU  || $scope.data.isPenyakitT08_TTU  || $scope.data.isPenyakitT09_TTU  || $scope.data.isPenyakitT10_TTU  || $scope.data.isPenyakitT11_TTU  || $scope.data.isPenyakitT12_TTU  || $scope.data.isPenyakitT13_TTU  || $scope.data.isPenyakitT14_TTU  || $scope.data.isPenyakitT15_TTU  || $scope.data.isPenyakitT16_TTU  || $scope.data.isPenyakitT17_TTU  || $scope.data.isPenyakitT18_TTU  || $scope.data.isPenyakitT19_TTU  || $scope.data.isPenyakitT20_TTU )){
						$scope.messages.push({
							'message': "Silahkan pilih salah satu gejala-gejala yang di derita"
						});
					}

					if($scope.data.isPenyakitT01_TTU){
						if($scope.data.tglSakitT01_TTU == '' || $scope.data.tglSakitT01_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit A. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT01_TTU == '' || $scope.data.namaDokterT01_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit A. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT01_TTU == '' || $scope.data.namaPenyakitT01_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit A. tertanggung utama, masih kosong"
							});
						}
					}
	
					if($scope.data.isPenyakitT02_TTU){
						if($scope.data.tglSakitT02_TTU == '' || $scope.data.tglSakitT02_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit B. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT02_TTU == '' || $scope.data.namaDokterT02_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit B. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT02_TTU == '' || $scope.data.namaPenyakitT02_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit B. tertanggung utama, masih kosong"
							});
						}
					}
	
					if($scope.data.isPenyakitT03_TTU){
						if($scope.data.tglSakitT03_TTU == '' || $scope.data.tglSakitT03_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit C. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT03_TTU == '' || $scope.data.namaDokterT03_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit C. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT03_TTU == '' || $scope.data.namaPenyakitT03_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit C. tertanggung utama, masih kosong"
							});
						}
					}
	
					if($scope.data.isPenyakitT04_TTU){
						if($scope.data.tglSakitT04_TTU == '' || $scope.data.tglSakitT04_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit D. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT04_TTU == '' || $scope.data.namaDokterT04_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit D. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT04_TTU == '' || $scope.data.namaPenyakitT04_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit D. tertanggung utama, masih kosong"
							});
						}
					}
	
					if($scope.data.isPenyakitT05_TTU){
						if($scope.data.tglSakitT05_TTU == '' || $scope.data.tglSakitT05_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit E. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT05_TTU == '' || $scope.data.namaDokterT05_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit E. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT05_TTU == '' || $scope.data.namaPenyakitT05_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit E. tertanggung utama, masih kosong"
							});
						}
					}
	
					if($scope.data.isPenyakitT06_TTU){
						if($scope.data.tglSakitT06_TTU == '' || $scope.data.tglSakitT06_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit F. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT06_TTU == '' || $scope.data.namaDokterT06_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit F. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT06_TTU == '' || $scope.data.namaPenyakitT06_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit F. tertanggung utama, masih kosong"
							});
						}
					}
	
					if($scope.data.isPenyakitT07_TTU){
						if($scope.data.tglSakitT07_TTU == '' || $scope.data.tglSakitT07_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit G. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT07_TTU == '' || $scope.data.namaDokterT07_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit G. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT07_TTU == '' || $scope.data.namaPenyakitT07_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit G. tertanggung utama, masih kosong"
							});
						}
					}
	
	
					if($scope.data.isPenyakitT08_TTU){
						if($scope.data.tglSakitT08_TTU == '' || $scope.data.tglSakitT08_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit H. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT08_TTU == '' || $scope.data.namaDokterT08_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit H. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT08_TTU == '' || $scope.data.namaPenyakitT08_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit H. tertanggung utama, masih kosong"
							});
						}
					}
	
					if($scope.data.isPenyakitT09_TTU){
						if($scope.data.tglSakitT09_TTU == '' || $scope.data.tglSakitT09_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit I. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT09_TTU == '' || $scope.data.namaDokterT09_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit I. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT09_TTU == '' || $scope.data.namaPenyakitT09_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit I. tertanggung utama, masih kosong"
							});
						}
					}
	
	
					if($scope.data.isPenyakitT10_TTU){
						if($scope.data.tglSakitT10_TTU == '' || $scope.data.tglSakitT10_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit J. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT10_TTU == '' || $scope.data.namaDokterT10_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit J. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT10_TTU == '' || $scope.data.namaPenyakitT10_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit J. tertanggung utama, masih kosong"
							});
						}
					}
	
					if($scope.data.isPenyakitT11_TTU){
						if($scope.data.tglSakitT11_TTU == '' || $scope.data.tglSakitT11_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit K. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT11_TTU == '' || $scope.data.namaDokterT11_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit K. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT11_TTU == '' || $scope.data.namaPenyakitT11_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit K. tertanggung utama, masih kosong"
							});
						}
					}
	
					if($scope.data.isPenyakitT12_TTU){
						if($scope.data.tglSakitT12_TTU == '' || $scope.data.tglSakitT12_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit L. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT12_TTU == '' || $scope.data.namaDokterT12_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit L. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT12_TTU == '' || $scope.data.namaPenyakitT12_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit L. tertanggung utama, masih kosong"
							});
						}
					}
	
					if($scope.data.isPenyakitT13_TTU){
						if($scope.data.tglSakitT13_TTU == '' || $scope.data.tglSakitT13_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit M. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT13_TTU == '' || $scope.data.namaDokterT13_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit M. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT13_TTU == '' || $scope.data.namaPenyakitT13_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit M. tertanggung utama, masih kosong"
							});
						}
					}
	
					if($scope.data.isPenyakitT14_TTU){
						if($scope.data.tglSakitT14_TTU == '' || $scope.data.tglSakitT14_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit N. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT14_TTU == '' || $scope.data.namaDokterT14_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit N. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT14_TTU == '' || $scope.data.namaPenyakitT14_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit N. tertanggung utama, masih kosong"
							});
						}
					}
	
					if($scope.data.isPenyakitT15_TTU){
						if($scope.data.tglSakitT15_TTU == '' || $scope.data.tglSakitT15_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit O. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT15_TTU == '' || $scope.data.namaDokterT15_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit O. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT15_TTU == '' || $scope.data.namaPenyakitT15_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit O. tertanggung utama, masih kosong"
							});
						}
					}
	
					if($scope.data.isPenyakitT16_TTU){
						if($scope.data.tglSakitT16_TTU == '' || $scope.data.tglSakitT16_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit P. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT16_TTU == '' || $scope.data.namaDokterT16_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit P. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT16_TTU == '' || $scope.data.namaPenyakitT16_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit P. tertanggung utama, masih kosong"
							});
						}
					}
	
					if($scope.data.isPenyakitT17_TTU){
						if($scope.data.tglSakitT17_TTU == '' || $scope.data.tglSakitT17_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit Q. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT17_TTU == '' || $scope.data.namaDokterT17_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit Q. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT17_TTU == '' || $scope.data.namaPenyakitT17_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit Q. tertanggung utama, masih kosong"
							});
						}
					}
	
					if($scope.data.isPenyakitT18_TTU){
						if($scope.data.tglSakitT18_TTU == '' || $scope.data.tglSakitT18_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit R. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT18_TTU == '' || $scope.data.namaDokterT18_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit R. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT18_TTU == '' || $scope.data.namaPenyakitT18_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit R. tertanggung utama, masih kosong"
							});
						}
					}

					if($scope.data.isPenyakitT19_TTU){
						if($scope.data.tglSakitT19_TTU == '' || $scope.data.tglSakitT19_TTU == null){
							$scope.messages.push({
								'message': "Tanggal Sakit penyakit R. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaDokterT19_TTU == '' || $scope.data.namaDokterT19_TTU == null){
							$scope.messages.push({
								'message': "Nama Dokter penyakit R. tertanggung utama, masih kosong"
							});
						}
	
						if($scope.data.namaPenyakitT19_TTU == '' || $scope.data.namaPenyakitT19_TTU == null){
							$scope.messages.push({
								'message': "Nama jenis penyakit R. tertanggung utama, masih kosong"
							});
						}
					}

					if($scope.data.isPenyakitT20_TTU){
						if( !($scope.data.isMataCacat_TTU || $scope.data.isKakiCacat_TTU || $scope.data.isTanganCacat_TTU) ){
							$scope.messages.push({
								'message': "Silahkan pilih salah satu, anggota tubuh yang cacat bawaan/kehilangan fungsi!"
							});
						}
	
						if($scope.data.isMataCacat_TTU){
							if($scope.data.isMataCacat__TTU == null || $scope.data.isMataCacat__TTU == ''){
								$scope.messages.push({
									'message': "Silahkan pilih salah satu, bagian mata yang cacat bawaan/ kehilangan fungsi"
								});
							}
						}

						
						if($scope.data.isKakiCacat_TTU){
							if($scope.data.isKakiCacat__TTU == null || $scope.data.isKakiCacat__TTU == ''){
								$scope.messages.push({
									'message': "Silahkan pilih salah satu, bagian Kaki yang cacat bawaan/ kehilangan fungsi"
								});
							}
						}

						if($scope.data.isTanganCacat_TTU){
							if($scope.data.isTanganCacat__TTU == null || $scope.data.isTanganCacat__TTU == ''){
								$scope.messages.push({
									'message': "Silahkan pilih salah satu, bagian Tangan yang cacat bawaan/ kehilangan fungsi"
								});
							}
						}
	
						
					}
				}



				if($scope.data.isNarkobaTTU == null){
					$scope.messages.push({
						'message': "Silahkan pilih, Ya/Tidak dalam hal menggunakan obat obatan terlarang!"
					});
				}

				if($scope.data.isObatLainTTU == null){
					$scope.messages.push({
						'message': "Silahkan pilih, Ya/Tidak dalam hal menggunakan obat obatan lain yang di konsumsi!"
					});
				}

				if($scope.data.isObatLainTTU){
					if($scope.data.jenisObatLainTTU == null || $scope.data.jenisObatLainTTU == ''){
						$scope.messages.push({
							'message': "Silahkan diisi jenisnya dan alasan penggunaannya!"
						});
					}
				}

				if($scope.data.isMinumAlkoholTTU == null){
					$scope.messages.push({
						'message': "Silahkan pilih, Ya/Tidak dalam hal minum minuman beralkohol lebih dari 750 ml per minggu!"
					});
				}

				if($scope.data.isMerokokTTU == null){
					$scope.messages.push({
						'message': "Silahkan pilih, Ya/Tidak dalam hal merokok!"
					});
				}

				if($scope.data.isMerokokTTU){
					if($scope.data.rokokBatangPerhariTTU == null || $scope.data.rokokBatangPerhariTTU == ''){
						$scope.messages.push({
							'message': "Silahkan isi berapa banyak batang rokok perhari!"
						});
					}

					if($scope.data.lamaMerokokTTU == null || $scope.data.lamaMerokokTTU == ''){
						$scope.messages.push({
							'message': "Silahkan isi berapa Sudah berapa lama merokok!"
						});
					}
				}

				if($scope.data.isCovid19TTU == null){
					$scope.messages.push({
						'message': "Silahkan pilih, Ya/Tidak dalam hal mengalami tanda dan/atau gejala gangguan kesehatan yang mengarah ke diagnosis COVID-19!"
					});
				}

				

				if($scope.data.isPengobatanDokterTTU == null){
					$scope.messages.push({
						'message': "Silahkan pilih, Ya/Tidak dalam hal memeriksakan pada dokter, dirawat di Rumah Sakit, Sanatorium, atau tempat istirahat lain karena sakit!"
					});
				}

				if($scope.data.isPengobatanDokterTTU){
					if($scope.data.namaPenyakitTTU == null ||$scope.data.namaPenyakitTTU == ''){
						$scope.messages.push({
							'message': "Nama penyakit tertanggung pada pertanyaan 7 masih kosong!"
						});
					}

					if($scope.data.kapanDirawatPenyakitTTU == null ||$scope.data.kapanDirawatPenyakitTTU == ''){
						$scope.messages.push({
							'message': "Kapan dirawat tertanggung pada pertanyaan 7 masih kosong!"
						});
					}

					if($scope.data.berapaLamaDirawatPenyakitTTU == null ||$scope.data.berapaLamaDirawatPenyakitTTU == ''){
						$scope.messages.push({
							'message': "Lama dirawat tertanggung pada pertanyaan 7 masih kosong!"
						});
					}

					if($scope.data.namaDosisObatPenyakitTTU == null ||$scope.data.namaDosisObatPenyakitTTU == ''){
						$scope.messages.push({
							'message': "Nama Dosis tertanggung pada pertanyaan 7 masih kosong!"
						});
					}

					if($scope.data.namaRSDokterPenyakitTTU == null ||$scope.data.namaRSDokterPenyakitTTU == ''){
						$scope.messages.push({
							'message': "Nama Rumah Sakit tertanggung pada pertanyaan 7 masih kosong!"
						});
					}
				}

				if($scope.data.isOperasiTTU == null){
					$scope.messages.push({
						'message': "Silahkan pilih, Ya/Tidak dalam hal pernah mendapatkan luka berat atau dioperasi!"
					});
				}

				if($scope.data.isOperasiTTU){
					if($scope.data.tglOperasiTTU == null || $scope.data.tglOperasiTTU == ''){
						$scope.messages.push({
							'message': "Kapan di operasi, pada pertanyaan 8 masih kosong!"
						});
					}

					if($scope.data.jenisOperasiTTU == null || $scope.data.jenisOperasiTTU == ''){
						$scope.messages.push({
							'message': "Jenis operasi, pada pertanyaan 8 masih kosong!"
						});
					}

					if($scope.data.namaRsDokterTTU == null || $scope.data.namaRsDokterTTU == ''){
						$scope.messages.push({
							'message': "Nama Rumah sakit, pada pertanyaan 8 masih kosong!"
						});
					}
				}

				if($scope.isTTUWanita){
					if($scope.data.isSKKUmumHamil_TTU == null){
						$scope.messages.push({
							'message': "Silahkan pilih, Ya/Tidak Apakah saat ini Anda dalam keadaan hamil?(Tertanggung Utama Perempuan)"
						});
					}
					
					if($scope.data.isSKKCesar_TTU == null){
						$scope.messages.push({
							'message': "Silahkan pilih, Ya/Tidak Apakah Anda pernah mengalami operasi (sectio caesarea), keguguran/aborsi/kehamilan diluar kandungan/ menderita kelainan payudara/ gangguan menstruasi/endometriosis/gangguan atau penyakit saat kehamilan atau melahirkan atau kelainan alat reproduksi lainnya?(Tertanggung Utama Perempuan)"
						});
					}

					if($scope.data.isSKKCesar_TTU){
						if($scope.data.SKKPernahCesar_TTU == null || $scope.data.SKKPernahCesar_TTU == ''){
							$scope.messages.push({
								'message': "Penyebab Operasi?(Tertanggung Utama Perempuan)"
							});
						}

						if($scope.data.SKKPernahCesarRS_TTU == null || $scope.data.SKKPernahCesarRS_TTU == ''){
							$scope.messages.push({
								'message': "Dokter yang pernah merawat?(Tertanggung Utama Perempuan)"
							});
						}
					}

					if($scope.data.isSKKUmumWanitaPAP_TTU == null){
						$scope.messages.push({
							'message': "Silahkan pilih, Ya/Tidak Apakah Anda pernah melakukan Pap Smear / USG kandungan / mamografi??(Tertanggung Utama Perempuan)"
						});
					}

					if($scope.data.isSKKUmumWanitaPAP_TTU){
						if($scope.data.tglPemeriksaanPAP_TTU == null || $scope.data.tglPemeriksaanPAP_TTU == ''){
							$scope.messages.push({
								'message': "Tgl. Pemeriksaan masih kosong! (Tertanggung Utama Perempuan)"
							});
						}

						if($scope.data.hasilPemeriksaanPAP_TTU == null || $scope.data.hasilPemeriksaanPAP_TTU == ''){
							$scope.messages.push({
								'message': "Hasil Pemeriksaan masih kosong! (Tertanggung Utama Perempuan)"
							});
						}
					}
					
				}

				
				/** Tertanggung tambahan 1 */
				if($scope.isTertanggungTambahan){
					if(!($scope.data.isHobiAdaTT1)){
						$scope.messages.push({
							'message': "Silahkan checklist hobi tertanggung tambahan terlebih dahulu"
						});
					}

					if($scope.data.isHobiAdaTT1){
						if($scope.data.hobbyTT1 == null){
							$scope.messages.push({
								'message': "Hobi tertanggung tambahan masih kosong"
							});
						}
					}

					if($scope.data.isPenyakitanOrtuTT1 == null){
						$scope.messages.push({
							'message': "Surat Kesehatan tertanggung tambahan masih kosong!"
						});
					}
	
					if($scope.data.isPenyakitanOrtuTT1){

						/** Ayah Tertanggung Tambahan */

						if($scope.data.umurAyahTT1 == 0 || $scope.data.umurAyahTT1 == null || $scope.data.umurAyahTT1 == ''){
							$scope.messages.push({
								'message': "Silahkan input usia Ayah Tertanggung Tambahan"
							});
						}

						if($scope.data.umurAyahTT1 <= 17){
							$scope.messages.push({
								'message': "Usia Ayah tertanggung tambahan harus di atas 17 tahun"
							});
						}

						if($scope.data.isAyahHidup_TT1 == null){
							$scope.messages.push({
								'message': "Status hidup/meninggal ayah tertanggung tambahan masih kosong."
							});
						}

						if($scope.data.isAyahHidup_TT1){

							if($scope.data.isAyahHidupSehat_TT1 == null){
								$scope.messages.push({
									'message': "Silahkan pilih salah satu keadaan Sehat/ Tidak Sehat ayah tertanggung tambahan!"
								});
							}

							if($scope.data.isAyahHidupSehat_TT1 != null && !($scope.data.isAyahHidupSehat_TT1)){
								if (!($scope.data.isAyahDiabet_TT1 || $scope.data.isAyahHipertensi_TT1 || $scope.data.isAyahJantung_TT1 || $scope.data.isAyahTumor_TT1 || $scope.data.isAyahPenyakitKeturunan_TT1)) {
									$scope.messages.push({
										'message': "Silahkan pilih salah satu jenis penyakit Ayah Tertanggung Tambahan!"
									});
								}
							}

						}

						if($scope.data.isAyahHidup_TT1 != null && !($scope.data.isAyahHidup_TT1)){
							if($scope.data.sebabMeninggalAyah_TT1 == ''){
								$scope.messages.push({
									'message': "penyebab meninggal ayah tertanggung tambahan, masih kosong!"
								});
							}
		
							if($scope.data.lamaSakitAyah_TT1 == ''){
								$scope.messages.push({
									'message': "lama sakit ayah tertanggung tambahan, masih kosong!"
								});
							}
		
							if($scope.data.tglMeninggal_TT1 == ''){
								$scope.messages.push({
									'message': "tanggal meninggal ayah tertanggung tambahan masih kosong!"
								});
							}
						}
						/** End Ayah Tertanggung Tambahan */


						/** Ibu Tertanggung Tambahan */

						if($scope.data.umurIbuTT1 == 0 || $scope.data.umurIbuTT1 == null || $scope.data.umurIbuTT1 == ''){
							$scope.messages.push({
								'message': "Silahkan input usia Ibu Tertanggung Tambahan"
							});
						}

						if($scope.data.umurIbuTT1 <= 17){
							$scope.messages.push({
								'message': "Usia Ibu tertanggung tambahan harus di atas 17 tahun"
							});
						}

						if($scope.data.isIbuHidup_TT1 == null){
							$scope.messages.push({
								'message': "Status hidup/meninggal Ibu tertanggung tambahan masih kosong."
							});
						}

						if($scope.data.isIbuHidup_TT1){

							if($scope.data.isIbuHidupSehat_TT1 == null){
								$scope.messages.push({
									'message': "Silahkan pilih salah satu keadaan Sehat/ Tidak Sehat Ibu tertanggung tambahan!"
								});
							}

							if($scope.data.isIbuHidupSehat_TT1 != null && !($scope.data.isIbuHidupSehat_TT1)){
								if (!($scope.data.isIbuDiabet_TT1 || $scope.data.isIbuHipertensi_TT1 || $scope.data.isIbuJantung_TT1 || $scope.data.isIbuTumor_TT1 || $scope.data.isIbuPenyakitKeturunan_TT1)) {
									$scope.messages.push({
										'message': "Silahkan pilih salah satu jenis penyakit Ibu Tertanggung Tambahan!"
									});
								}
							}

						}

						if($scope.data.isIbuHidup_TT1 != null && !($scope.data.isIbuHidup_TT1)){
							if($scope.data.sebabMeninggalIbu_TT1 == ''){
								$scope.messages.push({
									'message': "penyebab meninggal Ibu tertanggung tambahan, masih kosong!"
								});
							}
		
							if($scope.data.lamaSakitIbu_TT1 == ''){
								$scope.messages.push({
									'message': "lama sakit Ibu tertanggung tambahan, masih kosong!"
								});
							}
		
							if($scope.data.tglMeninggalIbu_TT1 == ''){
								$scope.messages.push({
									'message': "tanggal meninggal Ibu tertanggung tambahan masih kosong!"
								});
							}

						}
						/** End Ibu Tertanggung Tambahan */
					}
	
					if($scope.data.isPenyakitanKeluargaTT1 == null){
						$scope.messages.push({
							'message': "Silahkan pilih, Ya/Tidak ada keluarga tertanggung tambahan yang sakit!"
						});
					}

					if($scope.data.isPenyakitanKeluargaTT1){	
						/** Pasangan Tertanggung tambahan */
						if($scope.data.isAdaPasangan_TT1 == null){
							console.log('iya ini null')
							$scope.messages.push({
								'message': "pilihan status pasangan tertanggung tambahan masih kosong!"
							});
						}

						if($scope.data.isAdaPasangan_TT1){
							if($scope.data.umurPasanganTT1 == ''){
								$scope.messages.push({
									'message': "Umur pasangan tertanggung tambahan masih kosong!"
								});
							}

							if($scope.data.isPasanganHidup_TT1 == null){
								$scope.messages.push({
									'message': "Status keadaan hidup/meninggal pasangan masih kosong!"
								});
							}

							if($scope.data.isPasanganHidup_TT1){
								if($scope.data.isPasanganHidupSehat_TT1 == null){
									$scope.messages.push({
										'message': "Keadaan sehat/tidak sehat pasangan masih kosong!"
									});
								}

								if($scope.data.isPasanganHidupSehat_TT1 != null && !($scope.data.isPasanganHidupSehat_TT1)){
									if(!($scope.data.isPasanganDiabet_TT1 || $scope.data.isPasanganHipertensi_TT1 || $scope.data.isPasanganJantung_TT1 || $scope.data.isPasanganTumor_TT1 || $scope.data.isPasanganPenyakitKeturunan_TT1)){
										$scope.messages.push({
											'message': "Silahkan pilih salah satu jenis penyakit Pasangan!"
										});
									}
								}
							}

							if(!($scope.data.isPasanganHidup_TT1)){
								if($scope.data.sebabMeninggalPasangan_TT1 == ''){
									$scope.messages.push({
										'message': "penyebab meninggal Pasangan tertanggung, masih kosong!"
									});
								}
			
								if($scope.data.lamaSakitPasangan_TT1 == ''){
									$scope.messages.push({
										'message': "lama sakit Pasangan tertanggung, masih kosong!"
									});
								}
			
								if($scope.data.tglMeninggalPasangan_TT1 == ''){
									$scope.messages.push({
										'message': "tanggal meninggal pasangan tertanggung masih kosong!"
									});
								}

							}

							if($scope.data.tglMenikahTT1 == '' || $scope.data.tglMenikahTT1 == null){
								$scope.messages.push({
									'message': "tanggal menikah pasangan tertanggung masih kosong!"
								});
							}

						}

						if($scope.data.jumlahAnakTT1 == 1){
							if($scope.data.umurAnakTT1['0'] == null){
								$scope.messages.push({
									'message': "Usia anak pertama tertanggung masih kosong!"
								});
							}
		
						}
		
						if($scope.data.jumlahAnakTT1 == 2){
							if($scope.data.umurAnakTT1['0'] == null){
								$scope.messages.push({
									'message': "Usia anak pertama tertanggung tambahan masih kosong!"
								});
							}
		
							if($scope.data.umurAnakTT1['1'] == null){
								$scope.messages.push({
									'message': "Usia anak kedua tertanggung tambahan masih kosong!"
								});
							}
		
						}
		
						if($scope.data.jumlahAnakTT1 == 3){
							if($scope.data.umurAnakTT1['0'] == null){
								$scope.messages.push({
									'message': "Usia anak pertama tertanggung tambahan masih kosong!"
								});
							}
							
							if($scope.data.umurAnakTT1['1'] == null){
								$scope.messages.push({
									'message': "Usia anak kedua tertanggung tambahan masih kosong!"
								});
							}
		
							if($scope.data.umurAnakTT1['2'] == null){
								$scope.messages.push({
									'message': "Usia anak ketiga tertanggung tambahan masih kosong!"
								});
							}
		
						}
		
						if($scope.data.jumlahAnakTT1 == 4){
							if($scope.data.umurAnakTT1['0'] == null){
								$scope.messages.push({
									'message': "Usia anak pertama tertanggung tambahan masih kosong!"
								});
							}
							
							if($scope.data.umurAnakTT1['1'] == null){
								$scope.messages.push({
									'message': "Usia anak kedua tertanggung tambahan masih kosong!"
								});
							}
							
							if($scope.data.umurAnakTT1['2'] == null){
								$scope.messages.push({
									'message': "Usia anak ketiga tertanggung tambahan masih kosong!"
								});
							}
		
							if($scope.data.umurAnakTT1['3'] == null){
								$scope.messages.push({
									'message': "Usia anak keempat tertanggung tambahan masih kosong!"
								});
							}
		
						}
		
						if($scope.data.jumlahAnakTT1 == 5){
							if($scope.data.umurAnakTT1['0'] == null){
								$scope.messages.push({
									'message': "Usia anak pertama tertanggung tambahan masih kosong!"
								});
							}
							
							if($scope.data.umurAnakTT1['1'] == null){
								$scope.messages.push({
									'message': "Usia anak kedua tertanggung tambahan masih kosong!"
								});
							}
							
							if($scope.data.umurAnakTT1['2'] == null){
								$scope.messages.push({
									'message': "Usia anak ketiga tertanggung tambahan masih kosong!"
								});
							}
							
							if($scope.data.umurAnakTT1['3'] == null){
								$scope.messages.push({
									'message': "Usia anak keempat tertanggung tambahan masih kosong!"
								});
							}
		
							if($scope.data.umurAnakTT1['4'] == null){
								$scope.messages.push({
									'message': "Usia anak kelima tertanggung tambahan masih kosong!"
								});
							}
		
						}

						if($scope.data.jumlahSaudaraKandungLakiTT1 == 1){
							if($scope.data.umurSaudaraLkTT1['0'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung laki - laki pertama tertanggung tambahan masih kosong!"
								});
							}
						}
		
						if($scope.data.jumlahSaudaraKandungLakiTT1 == 2){
							if($scope.data.umurSaudaraLkTT1['0'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung laki - laki pertama tertanggung tambahan masih kosong!"
								});
							}
		
							if($scope.data.umurSaudaraLkTT1['1'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung laki - laki kedua tertanggung tambahan masih kosong!"
								});
							}
						}
		
						if($scope.data.jumlahSaudaraKandungLakiTT1 == 3){
							if($scope.data.umurSaudaraLkTT1['0'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung laki - laki pertama tertanggung tambahan masih kosong!"
								});
							}
							
							if($scope.data.umurSaudaraLkTT1['1'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung laki - laki kedua tertanggung tambahan masih kosong!"
								});
							}
		
							if($scope.data.umurSaudaraLkTT1['2'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung laki - laki ketiga tertanggung tambahan masih kosong!"
								});
							}
						}
		
						if($scope.data.jumlahSaudaraKandungLakiTT1 == 4){
							if($scope.data.umurSaudaraLkTT1['0'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung laki - laki pertama tertanggung tambahan masih kosong!"
								});
							}
							
							if($scope.data.umurSaudaraLkTT1['1'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung laki - laki kedua tertanggung tambahan masih kosong!"
								});
							}
							
							if($scope.data.umurSaudaraLkTT1['2'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung laki - laki ketiga tertanggung tambahan masih kosong!"
								});
							}
		
							if($scope.data.umurSaudaraLkTT1['3'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung laki - laki keempat tertanggung tambahan masih kosong!"
								});
							}
						}
		
						if($scope.data.jumlahSaudaraKandungLakiTT1 == 5){
							if($scope.data.umurSaudaraLkTT1['0'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung laki - laki pertama tertanggung tambahan masih kosong!"
								});
							}
							
							if($scope.data.umurSaudaraLkTT1['1'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung laki - laki kedua tertanggung tambahan masih kosong!"
								});
							}
							
							if($scope.data.umurSaudaraLkTT1['2'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung laki - laki ketiga tertanggung tambahan masih kosong!"
								});
							}
							
							if($scope.data.umurSaudaraLkTT1['3'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung laki - laki keempat tertanggung tambahan masih kosong!"
								});
							}
		
							if($scope.data.umurSaudaraLkTT1['4'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung laki - laki kelima tertanggung tambahan masih kosong!"
								});
							}
						}
		
						if($scope.data.jumlahSaudaraKandungPerempuanTT1 == 1){
							if($scope.data.umurSaudaraPrTT1['0'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung perempuan pertama tertanggung tambahan masih kosong!"
								});
							}
						}
		
						if($scope.data.jumlahSaudaraKandungPerempuanTT1 == 2){
							if($scope.data.umurSaudaraPrTT1['0'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung perempuan pertama tertanggung tambahan masih kosong!"
								});
							}
							if($scope.data.umurSaudaraPrTT1['1'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung perempuan kedua tertanggung tambahan masih kosong!"
								});
							}
						}
		
						if($scope.data.jumlahSaudaraKandungPerempuanTT1 == 3){
							if($scope.data.umurSaudaraPrTT1['0'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung perempuan pertama tertanggung tambahan masih kosong!"
								});
							}
							if($scope.data.umurSaudaraPrTT1['1'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung perempuan kedua tertanggung tambahan masih kosong!"
								});
							}
							if($scope.data.umurSaudaraPrTT1['2'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung perempuan ketiga tertanggung tambahan masih kosong!"
								});
							}
						}
		
						if($scope.data.jumlahSaudaraKandungPerempuanTT1 == 4){
							if($scope.data.umurSaudaraPrTT1['0'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung perempuan pertama tertanggung tambahan masih kosong!"
								});
							}
							if($scope.data.umurSaudaraPrTT1['1'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung perempuan kedua tertanggung tambahan masih kosong!"
								});
							}
							if($scope.data.umurSaudaraPrTT1['2'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung perempuan ketiga tertanggung tambahan masih kosong!"
								});
							}
							if($scope.data.umurSaudaraPrTT1['3'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung perempuan keempat tertanggung tambahan masih kosong!"
								});
							}
						}
		
						if($scope.data.jumlahSaudaraKandungPerempuanTT1 == 5){
							if($scope.data.umurSaudaraPrTT1['0'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung perempuan pertama tertanggung tambahan masih kosong!"
								});
							}
							if($scope.data.umurSaudaraPrTT1['1'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung perempuan kedua tertanggung tambahan masih kosong!"
								});
							}
							if($scope.data.umurSaudaraPrTT1['2'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung perempuan ketiga tertanggung tambahan masih kosong!"
								});
							}
							if($scope.data.umurSaudaraPrTT1['3'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung perempuan keempat tertanggung tambahan masih kosong!"
								});
							}
							if($scope.data.umurSaudaraPrTT1['4'] == null){
								$scope.messages.push({
									'message': "Usia Saudara kandung perempuan kelima tertanggung tambahan masih kosong!"
								});
							}
						}
					}

					if($scope.data.isSehatTT1 == null){
						$scope.messages.push({
							'message': "Status kesehatan tertanggung tambahan masih kosong!"
						});	
					}
	
					if(!($scope.data.isSehatTT1)){
						if($scope.data.alasanSakitTT1 == null || $scope.data.alasanSakitTT1 == ''){
							$scope.messages.push({
								'message': "Alasan Sakit tertanggung tambahan masih kosong!"
							});	
						}
					}
	
					if($scope.data.isPekerjaanBaikTT1 == null){
						$scope.messages.push({
							'message': "Silahkan pilih, Ya/Tidak dalam hal melakukan pekerjaan anda!" 
						});
					}
	
					if(!($scope.data.isPekerjaanBaikTT1)){
						if($scope.data.alasanPekerjaanBaikTT1 == null || $scope.data.alasanPekerjaanBaikTT1 == ''){
							$scope.messages.push({
								'message': "Alasan Tidak melakukan Pekerjaan dengan baik tertanggung tambahan masih kosong!"
							});	
						}
					}
	
					if($scope.data.isGejalaTT1 == null){
						$scope.messages.push({
							'message': "Silahkan pilih, Ya/Tidak dalam hal gejala gejala yang di derita tertanggung tambahan!"
						});
					}
	
					if($scope.data.isGejalaTT1){
						console.log($scope.data.isPenyakitT01_TT1)
						if(!($scope.data.isPenyakitT01_TT1 || $scope.data.isPenyakitT02_TT1 || $scope.data.isPenyakitT03_TT1  || $scope.data.isPenyakitT04_TT1  || $scope.data.isPenyakitT05_TT1  || $scope.data.isPenyakitT06_TT1  || $scope.data.isPenyakitT07_TT1  || $scope.data.isPenyakitT08_TT1  || $scope.data.isPenyakitT09_TT1  || $scope.data.isPenyakitT10_TT1  || $scope.data.isPenyakitT11_TT1  || $scope.data.isPenyakitT12_TT1  || $scope.data.isPenyakitT13_TT1  || $scope.data.isPenyakitT14_TT1  || $scope.data.isPenyakitT15_TT1  || $scope.data.isPenyakitT16_TT1  || $scope.data.isPenyakitT17_TT1  || $scope.data.isPenyakitT18_TT1  || $scope.data.isPenyakitT19_TT1  || $scope.data.isPenyakitT20_TT1 )){
							$scope.messages.push({
								'message': "Silahkan pilih salah satu gejala-gejala yang di derita tertanggung tambahan"
							});
						}
						if($scope.data.isPenyakitT01_TT1){
							if($scope.data.tglSakitT01_TT1 == '' || $scope.data.tglSakitT01_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit A. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT01_TT1 == '' || $scope.data.namaDokterT01_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit A. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT01_TT1 == '' || $scope.data.namaPenyakitT01_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit A. tertanggung tambahan, masih kosong"
								});
							}
						}
		
						if($scope.data.isPenyakitT02_TT1){
							if($scope.data.tglSakitT02_TT1 == '' || $scope.data.tglSakitT02_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit B. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT02_TT1 == '' || $scope.data.namaDokterT02_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit B. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT02_TT1 == '' || $scope.data.namaPenyakitT02_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit B. tertanggung tambahan, masih kosong"
								});
							}
						}
		
						if($scope.data.isPenyakitT03_TT1){
							if($scope.data.tglSakitT03_TT1 == '' || $scope.data.tglSakitT03_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit C. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT03_TT1 == '' || $scope.data.namaDokterT03_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit C. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT03_TT1 == '' || $scope.data.namaPenyakitT03_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit C. tertanggung tambahan, masih kosong"
								});
							}
						}
		
						if($scope.data.isPenyakitT04_TT1){
							if($scope.data.tglSakitT04_TT1 == '' || $scope.data.tglSakitT04_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit D. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT04_TT1 == '' || $scope.data.namaDokterT04_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit D. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT04_TT1 == '' || $scope.data.namaPenyakitT04_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit D. tertanggung tambahan, masih kosong"
								});
							}
						}
		
						if($scope.data.isPenyakitT05_TT1){
							if($scope.data.tglSakitT05_TT1 == '' || $scope.data.tglSakitT05_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit E. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT05_TT1 == '' || $scope.data.namaDokterT05_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit E. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT05_TT1 == '' || $scope.data.namaPenyakitT05_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit E. tertanggung tambahan, masih kosong"
								});
							}
						}
		
						if($scope.data.isPenyakitT06_TT1){
							if($scope.data.tglSakitT06_TT1 == '' || $scope.data.tglSakitT06_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit F. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT06_TT1 == '' || $scope.data.namaDokterT06_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit F. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT06_TT1 == '' || $scope.data.namaPenyakitT06_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit F. tertanggung tambahan, masih kosong"
								});
							}
						}
		
						if($scope.data.isPenyakitT07_TT1){
							if($scope.data.tglSakitT07_TT1 == '' || $scope.data.tglSakitT07_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit G. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT07_TT1 == '' || $scope.data.namaDokterT07_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit G. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT07_TT1 == '' || $scope.data.namaPenyakitT07_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit G. tertanggung tambahan, masih kosong"
								});
							}
						}
		
		
						if($scope.data.isPenyakitT08_TT1){
							if($scope.data.tglSakitT08_TT1 == '' || $scope.data.tglSakitT08_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit H. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT08_TT1 == '' || $scope.data.namaDokterT08_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit H. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT08_TT1 == '' || $scope.data.namaPenyakitT08_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit H. tertanggung tambahan, masih kosong"
								});
							}
						}
		
						if($scope.data.isPenyakitT09_TT1){
							if($scope.data.tglSakitT09_TT1 == '' || $scope.data.tglSakitT09_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit I. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT09_TT1 == '' || $scope.data.namaDokterT09_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit I. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT09_TT1 == '' || $scope.data.namaPenyakitT09_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit I. tertanggung tambahan, masih kosong"
								});
							}
						}
		
		
						if($scope.data.isPenyakitT10_TT1){
							if($scope.data.tglSakitT10_TT1 == '' || $scope.data.tglSakitT10_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit J. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT10_TT1 == '' || $scope.data.namaDokterT10_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit J. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT10_TT1 == '' || $scope.data.namaPenyakitT10_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit J. tertanggung tambahan, masih kosong"
								});
							}
						}
		
						if($scope.data.isPenyakitT11_TT1){
							if($scope.data.tglSakitT11_TT1 == '' || $scope.data.tglSakitT11_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit K. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT11_TT1 == '' || $scope.data.namaDokterT11_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit K. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT11_TT1 == '' || $scope.data.namaPenyakitT11_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit K. tertanggung tambahan, masih kosong"
								});
							}
						}
		
						if($scope.data.isPenyakitT12_TT1){
							if($scope.data.tglSakitT12_TT1 == '' || $scope.data.tglSakitT12_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit L. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT12_TT1 == '' || $scope.data.namaDokterT12_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit L. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT12_TT1 == '' || $scope.data.namaPenyakitT12_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit L. tertanggung tambahan, masih kosong"
								});
							}
						}
		
						if($scope.data.isPenyakitT13_TT1){
							if($scope.data.tglSakitT13_TT1 == '' || $scope.data.tglSakitT13_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit M. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT13_TT1 == '' || $scope.data.namaDokterT13_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit M. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT13_TT1 == '' || $scope.data.namaPenyakitT13_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit M. tertanggung tambahan, masih kosong"
								});
							}
						}
		
						if($scope.data.isPenyakitT14_TT1){
							if($scope.data.tglSakitT14_TT1 == '' || $scope.data.tglSakitT14_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit N. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT14_TT1 == '' || $scope.data.namaDokterT14_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit N. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT14_TT1 == '' || $scope.data.namaPenyakitT14_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit N. tertanggung tambahan, masih kosong"
								});
							}
						}
		
						if($scope.data.isPenyakitT15_TT1){
							if($scope.data.tglSakitT15_TT1 == '' || $scope.data.tglSakitT15_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit O. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT15_TT1 == '' || $scope.data.namaDokterT15_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit O. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT15_TT1 == '' || $scope.data.namaPenyakitT15_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit O. tertanggung tambahan, masih kosong"
								});
							}
						}
		
						if($scope.data.isPenyakitT16_TT1){
							if($scope.data.tglSakitT16_TT1 == '' || $scope.data.tglSakitT16_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit P. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT16_TT1 == '' || $scope.data.namaDokterT16_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit P. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT16_TT1 == '' || $scope.data.namaPenyakitT16_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit P. tertanggung tambahan, masih kosong"
								});
							}
						}
		
						if($scope.data.isPenyakitT17_TT1){
							if($scope.data.tglSakitT17_TT1 == '' || $scope.data.tglSakitT17_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit Q. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT17_TT1 == '' || $scope.data.namaDokterT17_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit Q. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT17_TT1 == '' || $scope.data.namaPenyakitT17_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit Q. tertanggung tambahan, masih kosong"
								});
							}
						}
		
						if($scope.data.isPenyakitT18_TT1){
							if($scope.data.tglSakitT18_TT1 == '' || $scope.data.tglSakitT18_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit R. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT18_TT1 == '' || $scope.data.namaDokterT18_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit R. tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT18_TT1 == '' || $scope.data.namaPenyakitT18_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit R. tertanggung tambahan, masih kosong"
								});
							}
						}

						if($scope.data.isPenyakitT19_TT1){
							if($scope.data.tglSakitT19_TT1 == '' || $scope.data.tglSakitT19_TT1 == null){
								$scope.messages.push({
									'message': "Tanggal Sakit penyakit Lainnya tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaDokterT19_TT1 == '' || $scope.data.namaDokterT19_TT1 == null){
								$scope.messages.push({
									'message': "Nama Dokter penyakit Lainnya tertanggung tambahan, masih kosong"
								});
							}
		
							if($scope.data.namaPenyakitT19_TT1 == '' || $scope.data.namaPenyakitT19_TT1 == null){
								$scope.messages.push({
									'message': "Nama jenis penyakit Lainnya tertanggung tambahan, masih kosong"
								});
							}
						}
	
						if($scope.data.isPenyakitT20_TT1){
							if( !($scope.data.isMataCacat_TT1  || $scope.data.isKakiCacat_TT1  || $scope.data.isTanganCacat_TT1) ){
								$scope.messages.push({
									'message': "Silahkan pilih salah satu, anggota tubuh yang cacat bawaan/kehilangan fungsi! (tertanggung tambahan)"
								});
							}
		
							if($scope.data.isMataCacat_TT1){
								if($scope.data.isMataCacat__TT1 == null || $scope.data.isMataCacat__TT1 == ''){
									$scope.messages.push({
										'message': "Silahkan pilih salah satu, bagian mata yang cacat bawaan/ kehilangan fungsi (tertanggung tambahan)"
									});
								}
							}
	
							
							if($scope.data.isKakiCacat_TT1){
								if($scope.data.isKakiCacat__TT1 == null || $scope.data.isKakiCacat__TT1 == ''){
									$scope.messages.push({
										'message': "Silahkan pilih salah satu, bagian Kaki yang cacat bawaan/ kehilangan fungsi (tertanggung tambahan)"
									});
								}
							}
	
							if($scope.data.isTanganCacat_TT1){
								if($scope.data.isTanganCacat__TT1 == null || $scope.data.isTanganCacat__TT1 == ''){
									$scope.messages.push({
										'message': "Silahkan pilih salah satu, bagian Tangan yang cacat bawaan/ kehilangan fungsi! (tertanggung tambahan)"
									});
								}
							}
		
							
						}
					}
	

					if($scope.data.isNarkobaTT1 == null){
						$scope.messages.push({
							'message': "Silahkan pilih, Ya/Tidak dalam hal menggunakan obat obatan terlarang tertanggung tambahan!"
						});
					}
	
					if($scope.data.isObatLainTT1 == null){
						$scope.messages.push({
							'message': "Silahkan pilih, Ya/Tidak dalam hal menggunakan obat obatan lain yang di konsumsi tertanggung tambahan!"
						});
					}

					if($scope.data.isObatLainTT1){
						if($scope.data.jenisObatLainTT1 == null || $scope.data.jenisObatLainTT1 == ''){
							$scope.messages.push({
								'message': "Silahkan diisi jenisnya dan alasan penggunaannya! (tertanggung tambahan)"
							});
						}
					}
	
					if($scope.data.isMinumAlkoholTT1 == null){
						$scope.messages.push({
							'message': "Silahkan pilih, Ya/Tidak dalam hal minum minuman beralkohol lebih dari 750 ml per minggu tertanggung tambahan!"
						});
					}
	
					if($scope.data.isMerokokTT1 == null){
						$scope.messages.push({
							'message': "Silahkan pilih, Ya/Tidak dalam hal merokok tertanggung tambahan!"
						});
					}

					if($scope.data.isMerokokTT1){
						if($scope.data.rokokBatangPerhariTT1 == null || $scope.data.rokokBatangPerhariTT1 == ''){
							$scope.messages.push({
								'message': "Silahkan isi berapa banyak batang rokok perhari! (tertanggung tambahan)"
							});
						}
	
						if($scope.data.lamaMerokokTT1 == null || $scope.data.lamaMerokokTT1 == ''){
							$scope.messages.push({
								'message': "Silahkan isi berapa Sudah berapa lama merokok! (tertanggung tambahan)"
							});
						}
					}
	
					if($scope.data.isCovid19TT1 == null){
						$scope.messages.push({
							'message': "Silahkan pilih, Ya/Tidak dalam hal mengalami tanda dan/atau gejala gangguan kesehatan yang mengarah ke diagnosis COVID-19 tertanggung tambahan!"
						});
					}
	
					if($scope.data.isPengobatanDokterTT1 == null){
						$scope.messages.push({
							'message': "Silahkan pilih, Ya/Tidak dalam hal memeriksakan pada dokter, dirawat di Rumah Sakit, Sanatorium, atau tempat istirahat lain karena sakit tertanggung tambahan!"
						});
					}

					if($scope.data.isPengobatanDokterTT1){
						if($scope.data.namaPenyakitTT1 == null ||$scope.data.namaPenyakitTT1 == ''){
							$scope.messages.push({
								'message': "Nama penyakit tertanggung tambahan pada pertanyaan 7 masih kosong!"
							});
						}
	
						if($scope.data.kapanDirawatPenyakitTT1 == null ||$scope.data.kapanDirawatPenyakitTT1 == ''){
							$scope.messages.push({
								'message': "Kapan dirawat tertanggung tambahan pada pertanyaan 7 masih kosong!"
							});
						}
	
						if($scope.data.berapaLamaDirawatPenyakitTT1 == null ||$scope.data.berapaLamaDirawatPenyakitTT1 == ''){
							$scope.messages.push({
								'message': "Lama dirawat tertanggung tambahan pada pertanyaan 7 masih kosong!"
							});
						}
	
						if($scope.data.namaDosisObatPenyakitTT1 == null ||$scope.data.namaDosisObatPenyakitTT1 == ''){
							$scope.messages.push({
								'message': "Nama Dosis tertanggung tambahan pada pertanyaan 7 masih kosong!"
							});
						}
	
						if($scope.data.namaRSDokterPenyakitTT1 == null ||$scope.data.namaRSDokterPenyakitTT1 == ''){
							$scope.messages.push({
								'message': "Nama Rumah Sakit tertanggung tambahan pada pertanyaan 7 masih kosong!"
							});
						}
					}
	
					if($scope.data.isOperasiTT1 == null){
						$scope.messages.push({
							'message': "Silahkan pilih, Ya/Tidak dalam hal pernah mendapatkan luka berat atau dioperasi tertanggung tambahan!"
						});
					}

					if($scope.data.isOperasiTT1){
						if($scope.data.tglOperasiTT1 == null || $scope.data.tglOperasiTT1 == ''){
							$scope.messages.push({
								'message': "Kapan di operasi, pada pertanyaan 8 tertanggung tambahan masih kosong!"
							});
						}
	
						if($scope.data.jenisOperasiTT1 == null || $scope.data.jenisOperasiTT1 == ''){
							$scope.messages.push({
								'message': "Jenis operasi, pada pertanyaan 8 tertanggung tambahan masih kosong!"
							});
						}
	
						if($scope.data.namaRsDokterTT1 == null || $scope.data.namaRsDokterTT1 == ''){
							$scope.messages.push({
								'message': "Nama Rumah sakit, pada pertanyaan 8 tertanggung tambahan masih kosong!"
							});
						}
					}

					if($scope.isTT1Wanita){
						if($scope.data.isSKKUmumHamil_TT1 == null){
							$scope.messages.push({
								'message': "Silahkan pilih, Ya/Tidak Apakah saat ini Anda dalam keadaan hamil?(Tertanggung Tambahan Perempuan)"
							});
						}
						
						if($scope.data.isSKKCesar_TT1 == null){
							$scope.messages.push({
								'message': "Silahkan pilih, Ya/Tidak Apakah Anda pernah mengalami operasi (sectio caesarea), keguguran/aborsi/kehamilan diluar kandungan/ menderita kelainan payudara/ gangguan menstruasi/endometriosis/gangguan atau penyakit saat kehamilan atau melahirkan atau kelainan alat reproduksi lainnya?(Tertanggung Tambahan Perempuan)"
							});
						}

						if($scope.data.isSKKCesar_TT1){
							if($scope.data.SKKPernahCesar_TT1 == null || $scope.data.SKKPernahCesar_TT1 == ''){
								$scope.messages.push({
									'message': "Penyebab Operasi?(Tertanggung Tambahan Perempuan)"
								});
							}
	
							if($scope.data.SKKPernahCesarRS_TT1 == null || $scope.data.SKKPernahCesarRS_TT1 == ''){
								$scope.messages.push({
									'message': "Dokter yang pernah merawat?(Tertanggung Tambahan Perempuan)"
								});
							}
						}
	
						if($scope.data.isSKKUmumWanitaPAP_TT1 == null){
							$scope.messages.push({
								'message': "Silahkan pilih, Ya/Tidak Apakah Anda pernah melakukan Pap Smear / USG kandungan / mamografi??(Tertanggung Tambahan Perempuan)"
							});
						}
	
						if($scope.data.isSKKUmumWanitaPAP_TT1){
							if($scope.data.tglPemeriksaanPAP_TT1 == null || $scope.data.tglPemeriksaanPAP_TT1 == ''){
								$scope.messages.push({
									'message': "Tgl. Pemeriksaan masih kosong! (Tertanggung Tambahan Perempuan)"
								});
							}
	
							if($scope.data.hasilPemeriksaanPAP_TT1 == null || $scope.data.hasilPemeriksaanPAP_TT1 == ''){
								$scope.messages.push({
									'message': "Hasil Pemeriksaan masih kosong! (Tertanggung Tambahan Perempuan)"
								});
							}
						}
						
					}
	
				}

			} catch (e) {
				$scope.messages.push({
					'message': "Data ERROR. " + e
				});
			}

			if ($scope.messages.length > 0) {
				return $scope.messages;
			}
			return false;
		}
		$scope.showAlert = function (title, message) {
			let alertPopup = $ionicPopup.alert({
				title: title,
				template: message
			});
			alertPopup.then(function (res) {
				//console.log('Thank you for not eating my delicious ice cream cone');
			});
		};
		$scope.moveToNextPage = function () {
			if ($scope.validateThisFormOnPageAccept()) {
				$scope.showAlert('Validasi', spajProvider.alertMessagebuilder($scope.messages));
				$scope.data.isSkkTertanggungAccepted = false;
				return false;
			} else {
				if ($scope.data.isSkkTertanggungAccepted) {
					if (confirm('Langsung menuju ke halaman form isian data diri pemegang polis?')) {
						$state.go('aplikasiSPAJOnline.dataPemegangPolis13', {}, {
							reload: false,
							inherit: false
						});
					} else {
						return false;
					}
				}
			}
		}
	}
])
.controller('daftarSPAJOnlineCtrl', ['$scope', '$state', '$stateParams', 'spajProvider', 'dataFactory', '$ionicPopup', '$http', '$ionicLoading', '$location', '$store', '$ionicScrollDelegate',
	function ($scope, $state, $stateParams, spajProvider, dataFactory, $ionicPopup, $http, $ionicLoading, $location, $store, $ionicScrollDelegate) {
		$scope.idagen = getQueryParam('idagen');
		$scope.token = getQueryParam('token');
		$scope.android_ver = getQueryParam('android_ver');
		$scope.device = getQueryParam('device');
		$scope.isOnline = 1;
		$scope.isDevice = false;
		/* Gunakan base url yang dinamik jika pindah ke production klo development defaultkan ke aims */
		//$scope.baseurl = window.location.protocol + "//" + window.location.host;
		$scope.baseurl = 'https://aims.ifg-life.id';
		//$scope.isOnline = spajProvider.isInternetAvailable();
		
		if(parseInt($scope.android_ver) > 0) $scope.isDevice = true;
		
		$scope.messages = [];
		
		$scope.isTab1 = true;
		$scope.isTab2 = false;
		$scope.isTab3 = false;
		$scope.isTab4 = false;
		
		$scope.changeTab = function(pnum){
			$scope.isTab1 = false;
			$scope.isTab2 = false;
			$scope.isTab3 = false;
			$scope.isTab4 = false;
			
			switch(pnum){
				case 1:
					$scope.isTab1 = true;
					$scope.isTab2 = false;
					$scope.isTab3 = false;
					$scope.isTab4 = false;
					break;
				case 2:
					$scope.isTab1 = false;
					$scope.isTab2 = true;
					$scope.isTab3 = false;
					$scope.isTab4 = false;
					break;
				case 3:					
					$scope.isTab1 = false;
					$scope.isTab2 = false;
					$scope.isTab3 = true;
					$scope.isTab4 = false;
					break;
				case 4:					
					$scope.isTab1 = false;
					$scope.isTab2 = false;
					$scope.isTab3 = false;
					$scope.isTab4 = true;
					break;
				default: ;
			}
		}

		$scope._Network_state = true;
		
		$scope._Check_Network_state  = function () {
			// Show a different icon based on offline/online
			if (navigator.onLine) { // true|false
				$scope._Network_state = true;
				$scope.isOnline = 1;
			} else {
				$scope._Network_state = false;
				$scope.isOnline = 0;
			}
			return $scope._Network_state;
		}
		
		window.addEventListener('online', $scope._Check_Network_state);
		window.addEventListener('offline', $scope._Check_Network_state);

		$scope.isValidToSubmit = function(guid){

			$scope.isValidDataTertanggung = false;
			$scope.isValidDataPempol = false;
			$scope.isValidDataPekerjaan = false;
			$scope.isValidSKK = false;
			$scope.isValidProdukPenerimaManfaat = false;
			$scope.isValidPersetujuan = false;
			//TERTANGGUNG
			let bol1 = false;
			let bol2 = false;
			let bol3 = false;
			$scope.sumberDataTertanggung1 = $store.get('SPAJ::' + guid + '::aplikasiSPAJOnline.dataTertanggung13');
			if ($scope.sumberDataTertanggung1 == null) {
				//$scope.messages.push({	'message': 'Silakan lengkapi data identitas tertanggung.'	})
			} else {bol1 = true;}
			
			$scope.sumberDataTertanggung2 = $store.get('SPAJ::' + guid + '::aplikasiSPAJOnline.dataTertanggung23');
			if ($scope.sumberDataTertanggung1 == null) {
				//$scope.messages.push({	'message': 'Silakan lengkapi data tempat tinggal tertanggung.'	})
			} else {bol2 = true;}
			
			$scope.sumberDataTertanggung3 = $store.get('SPAJ::' + guid + '::aplikasiSPAJOnline.dataTertanggung33');
			if ($scope.sumberDataTertanggung3 == null) {
				//$scope.messages.push({	'message': 'Silakan lengkapi data pendukung tertanggung.'	})
			} else {bol3 = true;}
			if (bol1 && bol2 && bol3) $scope.isValidDataTertanggung = true;
			

			//PEMPOL VALIDATION
			bol1 = false;
			bol2 = false;
			bol3 = false;
			$scope.sumberDataPempol1 = $store.get('SPAJ::' + guid + '::aplikasiSPAJOnline.dataPemegangPolis13');
			$scope.sumberDataPempol2 = $store.get('SPAJ::' + guid + '::aplikasiSPAJOnline.dataPemegangPolis23');
			$scope.sumberDataPempol3 = $store.get('SPAJ::' + guid + '::aplikasiSPAJOnline.dataPemegangPolis33');
			if ($scope.sumberDataPempol1 == null) {
				//$scope.messages.push({	'message': 'Silakan lengkapi data identitas pempoN.'	})
			} else {bol1 = true;}			
			if ($scope.sumberDataPempol2 == null) {
				//$scope.messages.push({	'message': 'Silakan lengkapi tempat tinggal pempol.'	})
			} else {bol2 = true;}			
			if ($scope.sumberDataPempol3 == null) {
				//$scope.messages.push({	'message': 'Silakan lengkapi data pendukung pempol.'	})
			} else {bol3 = true;}
			if (bol1 && bol2 && bol3) $scope.isValidDataPempol = true;
			//PEKERJAAN
			bol1 = false;
			$scope.pekerjaanTertanggung = $store.get('SPAJ::' + guid + '::aplikasiSPAJOnline.pekerjaanTertanggung');
			if ($scope.pekerjaanTertanggung == null) {
				//$scope.messages.push({	'message': 'Silakan lengkapi data pekerjaan Tertanggung.'	})
			} else {bol1 = true;}		
			
			bol2 = false;
			$scope.pekerjaanPemegangPolis = $store.get('SPAJ::' + guid + '::aplikasiSPAJOnline.pekerjaanPemegangPolis');
			if ($scope.pekerjaanPemegangPolis == null) {
				//$scope.messages.push({	'message': 'Silakan lengkapi data pekerjaan Pempol.'	})
			} else {bol2 = true;}	
			if (bol1 && bol2) $scope.isValidDataPekerjaan = true;
			
			bol1 = false;
			$scope.data_skk_utama = $store.get('SPAJ::' + guid + '::aplikasiSPAJOnline.sKKTertanggung');
			if ($scope.data_skk_utama == null) {
				//$scope.messages.push({	'message': 'Silakan lengkapi data SKK Tertanggung Utama.'	})
			} else {bol1 = true;}	
			if (bol1 ) $scope.isValidSKK = true;
			

			//DOKUMEN DAN PRODUK
			bol1 = false;
			bol2 = false;
			$scope.data_produk = $store.get('SPAJ::' + guid + '::aplikasiSPAJOnline.produkDanManfaat12');
			if ($scope.data_produk == null) {
				//$scope.messages.push({	'message': 'Silakan lengkapi data produk.'	})
			} else {
				bol1 = true;
				$scope.isValidSKK = $scope.data_produk.jenisAsuransi == 'PAA' || $scope.data_produk.jenisAsuransi == 'PAB' ? true : $scope.isValidSKK;
			}	
			
			$scope.data_dokumen = $store.get('SPAJ::' + guid + '::aplikasiSPAJOnline.dokumenPendukungSPAJ::dokumen_spaj');
			if ($scope.data_dokumen == null) {
				//$scope.messages.push({	'message': 'Silakan lengkapi data dokumen.'	})
			} else {bol2 = true;}	
			if (bol1 && bol2 ) $scope.isValidProdukPenerimaManfaat = true;
			
			//persetujuan

			$scope.data_persetujuan = $store.get('SPAJ::' + guid + '::aplikasiSPAJOnline.lembarPersetujuan');
			if ($scope.data_persetujuan == null) {
				//$scope.messages.push({	'message': 'Silakan lengkapi data persetujuan.'	})
			} else {bol1 = true;}	
			if (bol1) $scope.isValidPersetujuan = true;
			
/* 			console.log('1 ' + isValidDataTertanggung);
			console.log('2 ' + isValidDataPempol);
			console.log('3 ' + isValidDataPekerjaan);
			console.log('4 ' + isValidSKK);
			console.log('5 ' + isValidProdukPenerimaManfaat);
			console.log('6 ' + isValidPersetujuan); */
			
			isV = false;
			isV = ($scope.isValidDataTertanggung 
				&& $scope.isValidDataPempol 
				&& $scope.isValidDataPekerjaan
				&& $scope.isValidSKK 
				&& $scope.isValidProdukPenerimaManfaat
				&& $scope.isValidPersetujuan);
			//console.log(isV);
			return isV;
		}
		
		$scope.logout = function(){
			if (confirm('Apakah anda yakin untuk Logout?')) {
				localStorage.removeItem('loggedin');
				urlOk = 'login.html?android_ver='+$scope.android_ver;
				window.open(encodeURI(urlOk), '_self', 'location=no');
			}
		}
		
		$scope.deleteData = function () {
			if (confirm('Reset data. Akan menghapus data SPAJ baru yang belum Submit.')) {
				localStorage.clear();
				location.reload();
				console.log('RESET!!!');
			}
			return false;
		}
		$scope.$on('$ionicView.beforeEnter', function (event, viewData) {
			viewData.enableBack = true;
		});
		$scope.unsavedList = spajProvider.getUnsavedSpajGuid();
		
		$scope.dataUnprocessedUnderwriting = null;
		$scope.dataUnprocessedDitolak = null;
		$scope.dataUnprocessed = null;
		$scope.editUnsavedSpaj = function (spaj_guid) {
			//route to dataTertanggung13
			$state.go('aplikasiSPAJOnline.dataTertanggung13_tab1', {
				spaj_guid: spaj_guid
			}, {
				reload: false,
				inherit: false
			});
		}
		
		$scope.retrySubmit = function(spaj_guid){
			if($scope.isValidToSubmit(spaj_guid)){
				spajProvider.setSpajGUID(spaj_guid);
				$state.go('aplikasiSPAJOnline.tinjauUlangDanKirimDokumen', {
					spaj_guid: spaj_guid
				}, {
					reload: false,
					inherit: false
				});

			}else{
				alert('Dokumen belum dapat disubmit!');
				return false;
			}

		}
		
		$scope.showAlert = function(title,sub,template,buttontype) {
			$ionicPopup.alert({
				title:title,
				subTitle: sub,
				cssClass: 'popup-userinfo',
				scope: $scope,
				template: template,
				okType: buttontype
			});
		};
		$scope.dataProfile = "";
		$scope.showProfile = function(idagen){
			
			$ionicLoading.show({
				content: 'Loading',
				animation: 'fade-in',
				showBackdrop: true,
				maxWidth: 200,
				showDelay: 500
			});
				
			//url = 'https://aims.ifg-life.id/mobileapi/spaj_bridge/get.php?act=get_profile&idagen=';
			url = $scope.baseurl + '/mobileapi/spaj_bridge/get.php?act=get_profile&idagen=';
			$http({
				method: "GET",
				url: url + $scope.idagen 
			}).then(function mySucces(response) {
				$tdata = [];
				if (response.data == null) {}
					$scope.dataProfile = response.data;
					$ionicLoading.hide();
					
					tpl = '<div class="row">'
					tpl += '<div class="col" style="text-align:center;">';
					tpl += '<img style="width:80%;" src="'+$scope.baseurl+'/asset/avatar/'+idagen+'.jpg">';
					tpl += '</div>';
					tpl += '<div class="col">';
					tpl += '<div class = "list">Nama<label class = "item item-input"> <input style="float:right;" type = "text" placeholder = "Nama" value="'+$scope.dataProfile.NAMAKLIEN1+'"/></label></div>';
					tpl += '<div class = "list">Jabatan<label class = "item item-input"> <input type = "text" placeholder = "NAMAJABATANAGEN" value="'+$scope.dataProfile.NAMAJABATANAGEN+'"/></label></div>';
					tpl += '<div class = "list">No. Lisensi <label class = "item item-input"><input type = "text" placeholder = "NOLISENSIAGEN"  value="'+$scope.dataProfile.NOLISENSIAGEN+'" /></label></div>';
					tpl += '<div class = "list">Masa Berlaku Lisensi<label class = "item item-input"> <input type = "text" placeholder = "TGLMULAILISENSI TGLAKHIRLISENSI"  value="'+$scope.dataProfile.TGLMULAILISENSI +" s/d "+ $scope.dataProfile.TGLAKHIRLISENSI +'"/></label></div>';
					tpl += '';
					tpl += "</div></div> ";
					tpl += '<a style="" ng-hide="!isDevice" class="button button-block button-energized button-medium " ng-click="logout()">LOGOUT >></a>';

					$scope.showAlert('User Info',idagen,tpl,'button-balanced');
			}, function myError(response) {
				$ionicLoading.hide();
			}).withCredentials = true;

		}
/* 		$scope.scrollTo = function (target) {
			$location.hash(target); //set the location hash
			let handle = $ionicScrollDelegate.$getByHandle('myPageDelegate');
			handle.anchorScroll(true); // 'true' for animation
			console.log(target);
		}; */

		
		$http( {
			method: "GET",
			//url: "http://192.168.1.10:7780/mobileapi/spaj_bridge/retriever.php?act=get_unprocessed&idagen=" + $scope.idagen + "&token=" + $scope.token
			//url: "https://aims.ifg-life.id/mobileapi/spaj_bridge/get.php?act=get_processed&idagen=" + $scope.idagen + "&token=" + $scope.token
			url: $scope.baseurl+"/mobileapi/spaj_bridge/get.php?act=get_processed&idagen=" + $scope.idagen + "&token=" + $scope.token
		}).then(function mySucces(response) {
			
			$tdata = [];
			if (response.data == null) {}
			$scope.dataProcessed = response.data;
			$ionicLoading.hide();
		}, function myError(response) {
			
			$scope.dataProcessed = response.message;
			$ionicLoading.hide();
		}).withCredentials = true;
		
		$http({
			method: "GET",
			//url: "http://192.168.1.10:7780/mobileapi/spaj_bridge/retriever.php?act=get_unprocessed&idagen=" + $scope.idagen + "&token=" + $scope.token
			//url: "https://aims.ifg-life.id/mobileapi/spaj_bridge/get.php?act=get_underwrite&idagen=" + $scope.idagen + "&token=" + $scope.token
			url: $scope.baseurl+"/mobileapi/spaj_bridge/get.php?act=get_underwrite&idagen=" + $scope.idagen + "&token=" + $scope.token
		}).then(function mySucces(response) {
			
			$tdata = [];
			if (response.data == null) {}
			$scope.dataUnprocessedUnderwriting = response.data;
			$ionicLoading.hide();
		}, function myError(response) {
			$scope.dataUnprocessedUnderwriting = response.message;
			
			$ionicLoading.hide();
			//
		}).withCredentials = true;
		//untuk mapping link ke controller cetakan PDF 
		ctrl_pdf = function (obj, param) {
			return obj.find(obj => {
				return obj.id === param
			})
		}
		/* 			$http({
			                method: "GET",
							url: "http://192.168.1.10:7780/mobileapi/spaj_bridge/get.php?act=get_produk&idagen=" + $scope.idagen + "&token=" + $scope.token
			            }) */
		$http({
			method: "GET",
			//url: "http://192.168.1.10:7780/mobileapi/jsprosales2/?/api/get_prospek_list/" + $scope.idagen + ""
			//url: "https://aims.ifg-life.id/mobileapi/spaj_bridge/get.php?act=get_prospek&idagen=" + $scope.idagen + "&token=" + $scope.token
			url: $scope.baseurl+"/mobileapi/spaj_bridge/get.php?act=get_prospek&idagen=" + $scope.idagen + "&token=" + $scope.token
		}).then(function mySucces(response) {
			
			if (response.data[0] === null) {
				console.log("Tidak ada data prospek yang baru!");
			} else {
							console.log('test')
                            console.log(response);

							
				$tdata = [];
				for (i = 0; i < response.data.length; i++) {
					try{
						$dt = response.data[i].TGLLAHIRCTT.split('/');
						$dtp = response.data[i].TGLLAHIRCPP.split('/');
						$tlctt = $dt[2] + '-' + $dt[1] + '-' + $dt[0];
						$tlcpp = $dtp[2] + '-' + $dtp[1] + '-' + $dtp[0];
					}catch(e){
						$tlctt = '0000-00-00';
						$tlcpp = '0000-00-00';
					}
					$tdata.push({
						'build_id': response.data[i].BUILDID,
						'no_prospek': response.data[i].NO_PROSPEK,
						'cara_bayar': response.data[i].KDCARABAYAR,
						'namacarabayar' : response.data[i].NAMACARABAYAR,
						'jumlah_premi': response.data[i].PREMI,
						'premi_berkala': response.data[i].PREMIBERKALA,
						'topup_berkala': response.data[i].TOPUPBERKALA,
						'topup_sekaligus': response.data[i].TOPUPSEKALIGUS,
						'jua': response.data[i].JUA,
						'tgl_rekam': response.data[i].TGLREKAM,
						'id_produk': response.data[i].ID_PRODUK,
						'kd_produk': response.data[i].KDPRODUK,
						'namaproduk' : response.data[i].NAMAPRODUK,
						//'controller_pdf': ctrl_pdf(dataFactory.getJenisAsuransis(),response.data[i].KD_PRODUK).ctrl_pdf,
						'file_pdf': response.data[i].FILE_PDF,
						'nama': response.data[i].NAMA,
						'alamat': response.data[i].ALAMAT,
						'kdkota': response.data[i].KDKOTA,
						'kdprovinsi': response.data[i].KDPROVINSI,
						'kdpropinsi': response.data[i].KDPROPINSI,
						'kodepos': response.data[i].KODEPOS,
						'tgllahir': $tlctt,
						'email': response.data[i].EMAIL,
						'hp': response.data[i].HP,
						'no_ktp_tertanggung': response.data[i].NO_KTP,
						'kdjnspekerjaanttg' : response.data[i].KDJNSPEKERJAANTTG,
						'kdhobittg' : response.data[i].KDHOBITTG,
						'hubungan' : response.data[i].HUBUNGAN,
						'telp': response.data[i].TELP,
						'jeniskelamin': (response.data[i].JENISKELAMIN == 'M') ? 1 : 2,
						'is_perokok': response.data[i].IS_PEROKOK,
						'kode_alokasi': response.data[i].NAMAALOKASI1,
						'kode_alokasi1': response.data[i].KODEALOKASI1,
						'nama_alokasi1': response.data[i].NAMAALOKASI1,
						'kode_alokasi2': response.data[i].KODEALOKASI2,
						'nama_alokasi2': response.data[i].NAMAALOKASI2,
						'alokasi1': response.data[i].PERSENALOKASI1,
						'alokasi2': response.data[i].PERSENALOKASI2,
						'penghasilan': response.data[i].PENGHASILAN,
						'namaAgen': response.data[i].NAMAAGEN,
						'KDJABATANAGEN': response.data[i].KDJABATANAGEN,
						'NAMAJABATANAGEN': response.data[i].NAMAJABATANAGEN,
						
						'IS_ADDB' : response.data[i].ISADDB == '1' ? true : false,
						'ADDB' : response.data[i].ADDB,
						'IS_TPD' : response.data[i].ISTPD == '1' ? true : false,
						'TPD' : response.data[i].TPD,
						'IS_HCP_MURNI' : response.data[i].ISHCPMURNI != '0' ? true : false,
						'HCP_TYPE_SELECT' : response.data[i].ISHCPMURNI,
						'PLAFON_HCP_MURNI' : response.data[i].PLAFONHCPMURNI,
						'HCP_MURNI' : response.data[i].HCPMURNI,
						'IS_HCP_BEDAH' : response.data[i].ISHCPBEDAH == '1' ? true : false,
						'PLAFON_HCP_BEDAH' : response.data[i].PLAFONHCPBEDAH,
						'HCP_BEDAH' : response.data[i].HCPBEDAH,
						'IS_CI' : response.data[i].ISCI == '1' ? true : false,
						'CI' : response.data[i].CI,
						'IS_TL' : response.data[i].ISTL == '1' ? true : false,
						'TL' : response.data[i].TL,
						'IS_PAYOR_DEATH' : response.data[i].ISPD == '1' ? true : false,
						'PAYOR_DEATH' : response.data[i].PD,
						'IS_PAYOR_TPD' : response.data[i].ISPTPD == '1' ? true : false,
						'PAYOR_TPD' : response.data[i].PTPD,
						'IS_SPOUSE_DEATH' : response.data[i].ISSD == '1' ? true : false,
						'SPOUSE_DEATH' : response.data[i].SD,
						'IS_WAIVER_TPD' : response.data[i].ISWTPD == '1' ? true : false,
						'WAIVER_TPD' : response.data[i].WTPD,
						'IS_WAIVER_CI' : response.data[i].ISWCI == '1' ? true : false,
						'WAIVER_CI' : response.data[i].WCI,
						'IS_SPOUSE_TPD' : response.data[i].ISSTPD == '1' ? true : false,
						'SPOUSE_TPD' : response.data[i].STPD,
						'IS_ADB' : response.data[i].ISADB == '1' ? true : false,
						'ADB' : response.data[i].ADB,
						'ispci' : response.data[i].ISPCI == '1' ? true : false,
						'pci' : response.data[i].PCI,
						'issci' : response.data[i].ISSCI == '1' ? true : false,
						'sci' : response.data[i].SCI,
						
						/*'ADB': response.data[i].ADB,
						'ADDB': response.data[i].ADDB,
						'CI': response.data[i].CI,
						'HCP_BEDAH': response.data[i].HCP_BEDAH,
						'HCP_MURNI': response.data[i].HCP_MURNI,
						'IS_ADB': (response.data[i].IS_ADB == '1')?true:false,
						'IS_ADDB': (response.data[i].IS_ADDB == '1')?true:false,
						'IS_CI': (response.data[i].IS_CI == '1')?true:false,
						'IS_HCP_BEDAH': (response.data[i].IS_HCP_BEDAH != '0')?true:false,
						'IS_HCP_MURNI': (response.data[i].IS_HCP_MURNI != '0')?true:false,
						'IS_PAYOR_DEATH': (response.data[i].IS_PAYOR_DEATH == '1')?true:false,
						'IS_PAYOR_TPD': (response.data[i].IS_PAYOR_TPD == '1')?true:false,
						'IS_SPOUSE_DEATH': (response.data[i].IS_SPOUSE_DEATH == '1')?true:false,
						'IS_SPOUSE_TPD': (response.data[i].IS_SPOUSE_TPD == '1')?true:false,
						'IS_TL': (response.data[i].IS_TL == '1')?true:false,
						'IS_TPD': (response.data[i].IS_TPD == '1')?true:false,
						'IS_WAIVER_CI': (response.data[i].IS_WAIVER_CI == '1')?true:false,
						'IS_WAIVER_TPD': (response.data[i].IS_WAIVER_TPD == '1')?true:false,
						'PAYOR_DEATH': response.data[i].PAYOR_DEATH,
						'PAYOR_TPD': response.data[i].PAYOR_TPD,
						'PLAFON_HCP_BEDAH': response.data[i].PLAFON_HCP_BEDAH,
						'PLAFON_HCP_MURNI': response.data[i].PLAFON_HCP_MURNI,
						'SPOUSE_DEATH': response.data[i].SPOUSE_DEATH,
						'SPOUSE_TPD': response.data[i].SPOUSE_TPD,
						'TL': response.data[i].TL,
						'TPD': response.data[i].TPD,
						'WAIVER_CI': response.data[i].WAIVER_CI,
						'WAIVER_TPD': response.data[i].WAIVER_TPD,*/
						
						'namacpp' : response.data[i].NAMACPP,
						'alamatcpp' : response.data[i].ALAMATCPP,
						'kdkotamadyacpp' : response.data[i].KDKOTAMADYACPP,
						'kdpropinsicpp' : response.data[i].KDPROPINSICPP,
						'kdposcpp' : response.data[i].KDPOSCPP,
						'tgllahircpp' : $tlcpp,
						'usiacpp' : response.data[i].USIACPP,
						'kdjeniskelamincpp' : response.data[i].KDJENISKELAMINCPP,
						'teleponcpp' : response.data[i].TELEPONCPP,
						'hpcpp' : response.data[i].HPCPP,
						'emailcpp' : response.data[i].EMAILCPP,
						'noktpcpp' : response.data[i].NOKTPCPP,
						'kdpekerjaancpp' : response.data[i].KDPEKERJAANCPP,
						'namapekerjaancpp' : response.data[i].NAMAPEKERJAANCPP,
						'kdhobicpp' : response.data[i].KDHOBICPP,
						'namahobicpp' : response.data[i].NAMAHOBICPP,
						'maritalstatuscpp' : response.data[i].MARITALSTATUSCPP,
						'merokokcpp' : response.data[i].MEROKOKCPP,
						'usiaproduktif' : response.data[i].USIA_PRODUKTIF,
						
						'kdhubunganctt' : response.data[i].KDHUBUNGANCTT,
						'namahubunganctt' : response.data[i].NAMAHUBUNGANCTT,
						'namactt' : response.data[i].NAMACTT,
						'tgllahirctt' : $tlctt,
						'usiactt' : response.data[i].USIACTT,
						'kdjeniskelaminctt' : response.data[i].KDJENISKELAMINCTT,
						'teleponctt' : response.data[i].TELEPONCTT,
						'hpctt' : response.data[i].HPCTT,
						'emailctt' : response.data[i].EMAILCTT,
						'noktpctt' : response.data[i].NOKTPCTT,
						'kdpekerjaanctt' : response.data[i].KDPEKERJAANCTT,
						'namapekerjaanctt' : response.data[i].NAMAPEKERJAANCTT,
						'kdhobictt' : response.data[i].KDHOBICTT,
						'namahobictt' : response.data[i].NAMAHOBICTT,
						'merokokctt' : response.data[i].MEROKOKCTT
					})
				}
			}
			
			//console.log($tdata);

			spajProvider.setProspekListData($scope.idagen,$tdata);
			spajProvider.setInternetAvailability(1);
			$ionicLoading.hide();

			//set offline buffer
			$scope.dataProspek = spajProvider.getProspekListData($scope.idagen);
			
		}, function myError(response) {
			//$scope.dataProspek = response.message;
			$scope.dataProspek = spajProvider.getProspekListData($scope.idagen);
			spajProvider.setInternetAvailability(0);
			
			console.log('offline mode...');
		}).withCredentials = true;
		

		$scope.deleteUnsavedSpaj = function (spaj_guid) {
			if (confirm('Apakah ingin menghapus dokumen SPAJ ini?')) {
				spajProvider.delUnsavedSpajGuid(spaj_guid);
				location.reload();
				return true;
			}
		}
		
		$scope.deleteProcessSpaj = function (nospaj, noagen) {
			if (confirm('Apakah ingin menghapus dokumen SPAJ ini '+nospaj+'?')) {
				url = $scope.baseurl + '/mobileapi/spaj_bridge/delete.php?nospaj='+nospaj+'&noagen='+noagen;
				
				$http({
					method: "GET",
					url: url + $scope.idagen 
				}).then(function mySucces(response) {
					console.log(response);
				}, function myError(response) {
					
				}).withCredentials = true;
				
				location.reload();
				return true;
			}
		}
		
		$scope.showDeleteSpaj = function(status) {
			if (status == '1')
				return false;
			else 
				return true;
		}
		
		$scope.editSpaj = function (item) {
			//console.log(item);
			//$location.path('/basic_tertanggung1'); 
			$state.go('aplikasiSPAJOnline.dataTertanggung13_tab1', {}, {
				reload: true,
				inherit: false
			});
		}
		
		$scope.doNewSPAJ = function () {
			$state.go('aplikasiSPAJOnline', {}, {
				reload: true,
				inherit: false
			});
		}

 		$scope.alertJabatan = function (jab) {
			if(jab == '02' || jab == '19'){
				jabs = '';
				if(jab =='02') jabs = 'AGENCY MANAGER';
				if(jab =='19') jabs = 'SAM';
				alert('Jabatan '+jabs+' Tidak dapat mengirim eSPAJ. \n\nSesuai dengan Pedoman Sistem Keagenan Ritel v.2.0: 446.SK.R.1219, Bab 2. Huruf E. Tanggal 20 Desember 2019 ')
			}
		}

		$scope.newSpajProspek = function (build_id) {		
			spajProvider.setSpajGUID('new');
			spajProvider.setBuildId(build_id);
			spajProvider.setProspekData(JSON.stringify($scope.dataProspek));
			$state.go('aplikasiSPAJOnline.dataTertanggung13_tab1', {
				spaj_guid: 'new'
			}, {
				reload: true,
				inherit: false
			});
		}
		/* 	$ionicLoading.show({
					content: '<ion-spinner></ion-spinner>',
					animation: 'fade-in',
					showBackdrop: true,
					maxWidth: 400,
					showDelay: 1
				}); */
	}
])
.controller('aplikasiSPAJOnlineCtrl', ['$scope', '$state', '$stateParams', 'spajProvider', 'dataFactory', '$ionicPopup', '$http', '$ionicLoading', '$location', '$store', '$ionicScrollDelegate',

	function ($scope, $state, $stateParams, spajProvider, dataFactory, $ionicPopup, $http, $ionicLoading, $location, $store, $ionicScrollDelegate) {
		prospek = false;
		try {
			$pros = JSON.parse(spajProvider.getProspekData());
			prospek = $pros.find(obj => {
				return obj.build_id === spajProvider.getBuildId()
			});
		} catch (e) {}
		
		$scope.skkVisible = prospek.kd_produk == 'PAA' || prospek.kd_produk == 'PAB' || prospek.kd_produk.match(/APP/i) ? false : true;
		console.log($scope.skkVisible);
		console.log(prospek.kd_produk);
	}
])
/////////////