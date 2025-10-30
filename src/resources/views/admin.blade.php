@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/admin.css')}}">
@endsection

@section('btn')
<div class="logout__button">
    <button class="logout__button-submit" type="button" onclick="location.href='/login'">logout</button>
</div>
@endsection

@section('content')
<div class="admin-form__content">
    <div class="admin-form__heading">
        <h2>Admin</h2>
    </div>
    <form class="search-form" action="{{ route('admin.search') }}" method="get">
        @csrf
        <div class="search-form__item">
            <input class="search-form__item-name" type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ old('keyword') }}">
            <select class="search-form__item-gender" name="gender">
                <option value="">性別</option>
                <option value="">全て</option>
                <option value="1">男性</option>
                <option value="2">女性</option>
                <option value="3">その他</option>
            </select>
            <select class="search-form__item-category" name="category_id">
                <option value="">お問い合わせの種類</option>
                @foreach($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['content'] }}</option>
                @endforeach
            </select>
            <input class="search-form__item-date"  type="date" name="date" value="{{ $category['created_at'] }}">
        </div>
        <div class="search-form__button">
            <button class="search__button-submit" type="submit">検索</button>
            <button class="reset__button-submit" type="button" onclick="location.href='/admin'">リセット</button>
        </div>
    </form>
    <div class="search-form__option">
        <form action="{{  route('admin.export') }}" method="GET">
            @csrf
            <input type="hidden" name="keyword" value="{{ request('keyword') }}">
            <input type="hidden" name="gender" value="{{ request('gender') }}">
            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            <div class="export__button">
                <button class="export__button-submit" type="submit">エクスポート</button>
            </div>
        </form>
        <div class="pagination">
            {{ $contacts->links('pagination.custom') }}
        </div>
    </div>

    <div class="admin-table">
        <table class="admin-table__inner">
            <tr class="admin-table__row">
                <th class="admin-table__header">お名前</th>
                <th class="admin-table__header">性別</th>
                <th class="admin-table__header">メールアドレス</th>
                <th class="admin-table__header">お問い合わせの種類</th><th class="admin-table__header"></th>
            </tr>
            @foreach($contacts as $contact)
            <tr class="admin-table__row">
                <td class="admin-table__item">{{ $contact['first_name'] }} {{ $contact['last_name'] }}</td>
                <td class="admin-table__item"> {{ $contact['gender'] == 1 ? '男性' : ($contact['gender'] == 2 ? '女性' : 'その他') }}</td>
                <td class="admin-table__item">{{$contact['email']}}</td>
                <td class="admin-table__item">{{ $contact->category->content }}</td>
                <td class="admin-table__item">
                    <button class="detail__button" type="button"
                    data-id="{{ $contact['id'] }}"
                    data-first-name="{{ $contact['first_name'] }}"
                    data-last-name="{{ $contact['last_name'] }}"
                    data-gender="{{ $contact['gender'] == 1 ? '男性' : ($contact['gender'] == 2 ? '女性' : 'その他') }}"
                    data-email="{{ $contact['email'] }}"
                    data-tel="{{ $contact['tel'] ?? '' }}"
                    data-address="{{ $contact['address'] ?? '' }}"
                    data-building="{{ $contact['building'] ?? '' }}"
                    data-category="{{ $contact->category->content }}"
                    data-detail="{{ $contact['detail'] }}">詳細</button>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="modal-content">
            <div class="modal__button">
                <button class="modal__button--close" type="button">&times;</button>
            </div>
            <div class="modal__item">
                <div class="modal__item--heading">お名前</div>
                <div class="modal__item--value" id="modal-first-name"></div>
                <div class="modal__item--value" id="modal-last-name"></div>
            </div>
            <div class="modal__item">
                <div class="modal__item--heading">性別</div>
                <div class="modal__item--value" id="modal-gender"></div>
            </div>
            <div class="modal__item">
                <div class="modal__item--heading">メールアドレス</div>
                <div class="modal__item--value" id="modal-email"></div>
            </div>
            <div class="modal__item">
                <div class="modal__item--heading">電話番号</div>
                <div class="modal__item--value" id="modal-tel"></div>
            </div>
            <div class="modal__item">
                <div class="modal__item--heading">住所</div>
                <div class="modal__item--value" id="modal-address"></div>
            </div>
            <div class="modal__item">
                <div class="modal__item--heading">建物名</div>
                <div class="modal__item--value" id="modal-building"></div>
            </div>
            <div class="modal__item">
                <div class="modal__item--heading">お問い合わせの種類</div>
                <div class="modal__item--value" id="modal-category"></div>
            </div>
            <div class="modal__item">
                <div class="modal__item--heading">お問い合わせの内容</div>
                <div class="modal__item--value" id="modal-detail"></div>
            </div>
            <form class="modal__delete" action="/admin/delete" method="post" id="modal-delete-form">
                @method('DELETE')
                @csrf
                <input type="hidden" name="id" id="modal-delete-id"value="">
                <button class="modal__delete--button" type="submit">削除</button>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const detailButtons = document.querySelectorAll('.detail__button');
    const modal = document.querySelector('.modal-content');
    const closeModal = document.querySelector('.modal__button--close');
    const deleteIdInput = document.getElementById('modal-delete-id');

    detailButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const btn = e.currentTarget;
            document.getElementById('modal-first-name').textContent = btn.dataset.firstName;
            document.getElementById('modal-last-name').textContent = btn.dataset.lastName;
            document.getElementById('modal-gender').textContent = btn.dataset.gender;
            document.getElementById('modal-email').textContent = btn.dataset.email;
            document.getElementById('modal-tel').textContent = btn.dataset.tel;
            document.getElementById('modal-address').textContent = btn.dataset.address;
            document.getElementById('modal-building').textContent = btn.dataset.building;
            document.getElementById('modal-category').textContent = btn.dataset.category;
            document.getElementById('modal-detail').textContent = btn.dataset.detail;

            deleteIdInput.value = btn.dataset.id;

            modal.classList.add('modal-active');
        });
    });

    closeModal.addEventListener('click', function() {
        modal.classList.remove('modal-active');
    });
});
</script>
@endsection