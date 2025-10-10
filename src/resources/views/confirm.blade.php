@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/confirm.css')}}">
@endsection

@section('content')
<div class="contact-form__content">
    <div class="contact-form__heading">
        <h2>Confirm</h2>
    </div>
    <form class="form" action="">
        @csrf
        <div class="confirm-table">
            <table class="confirm-table__inner">
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お名前</th>
                    <td class="confirm-table__text">
                        <input type="text" name="first_name" value=""/>
                        <input type="text" name="last_name" value=""/>
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">性別</th>
                    <td class="confirm-table__text">
                        <input type="text" name="gender" value=""/>
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__heading">メールアドレス</th>
                    <td class="confirm-table_text">
                        <input type="email" name="email" value=""/>
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <td class="confirm-table__text">
                        <input type="tel" name="tel" value=""/>
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <td class="confirm-table__text">
                        <input type="text" name="address" value=""/>
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <td class="confirm-table__text">
                        <input type="text" name="building" value=""/>
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <td class="confirm-table__text">
                        <!--select-->
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <td class="confirm-table__text">
                        <input type="text" name="detail" value=""/>
                    </td>
                </tr>
            </table>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">送信</button>
            <button class="form-button-modify" type="button" onclick="history.back();">修正</button>
        </div>
    </form>
</div>
@endsection