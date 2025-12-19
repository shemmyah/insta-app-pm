@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="ig-create-wrap">
    <div class="ig-create-card">

        <div class="ig-create-head">
            <div class="ig-create-title">Edit post</div>
            <button type="submit" form="editPostForm" class="ig-post-btn">Save</button>
        </div>

        <form id="editPostForm" action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data" class="ig-create-form">
            @csrf
            @method('PATCH')

            {{-- Image preview + upload --}}
            <div class="ig-block">
                <label class="ig-label" for="image">Image</label>

                <div class="ig-preview">
                    <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="ig-preview-img" id="previewImg">
                </div>

                <label class="ig-drop" for="image">
                    <div class="ig-drop-title">Change photo</div>
                    <div class="ig-drop-sub">click to upload</div>
                </label>

                <input type="file" name="image" id="image" class="ig-file" accept="image/jpeg,image/png,image/gif,image/jpg">

                <div class="ig-help">
                    Acceptable: jpeg, jpg, png, gif ・ Max: 1048kB
                </div>

                @error('image')
                    <div class="ig-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Description --}}
            <div class="ig-block">
                <label for="description" class="ig-label">Caption</label>
                <textarea name="description" id="description" rows="3" class="ig-textarea"
                    placeholder="Write a caption...">{{ old('description', $post->description) }}</textarea>
                @error('description')
                    <div class="ig-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Categories --}}
            <div class="ig-block">
                <div class="ig-label-row">
                    <label class="ig-label mb-0">Category</label>
                    <span class="ig-muted">(up to 3)</span>
                </div>

                <div class="ig-tags">
                    @foreach ($all_categories as $category)
                        <input type="checkbox"
                               name="category[]"
                               id="cat-{{ $category->id }}"
                               value="{{ $category->id }}"
                               class="ig-tag-check"
                               {{ in_array($category->id, $selected_categories) ? 'checked' : '' }}>

                        <label for="cat-{{ $category->id }}" class="ig-tag">{{ $category->name }}</label>
                    @endforeach
                </div>

                @error('category')
                    <div class="ig-error">{{ $message }}</div>
                @enderror
            </div>

        </form>

        <div class="ig-create-foot">
            <button type="submit" form="editPostForm" class="ig-post-btn w-100">Save</button>
        </div>
    </div>
</div>

{{-- 画像差し替え時にプレビュー更新（インスタっぽくて便利） --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("image");
  const preview = document.getElementById("previewImg");
  if (!input || !preview) return;

  input.addEventListener("change", (e) => {
    const file = e.target.files?.[0];
    if (!file) return;
    const url = URL.createObjectURL(file);
    preview.src = url;
  });
});
</script>

<style>
/* ====== 完全ダーク版 ====== */
body{
  background:#0b1118 !important;
  color:#e6edf3;
}

.ig-create-wrap{
  padding: 28px 0;
  display:flex;
  justify-content:center;
}

.ig-create-card{
  width: min(520px, 92vw);
  background:#0f1720;
  border:1px solid #22303c;
  border-radius:14px;
  overflow:hidden;
  box-shadow: 0 20px 70px rgba(0,0,0,.55);
}

.ig-create-head{
  display:flex;
  align-items:center;
  justify-content:space-between;
  padding:14px 16px;
  border-bottom:1px solid #22303c;
}
.ig-create-title{
  font-weight:800;
  letter-spacing:.2px;
  color:#e6edf3;
}

.ig-create-form{
  padding: 16px;
  display:flex;
  flex-direction:column;
  gap:16px;
}

.ig-block{ display:flex; flex-direction:column; gap:8px; }
.ig-label{ font-weight:800; font-size:14px; color:#e6edf3; }
.ig-label-row{ display:flex; align-items:baseline; gap:8px; }
.ig-muted{ color:#9aa7b4; font-size:13px; }

/* preview */
.ig-preview{
  border:1px solid #22303c;
  background:#0b141c;
  border-radius:14px;
  overflow:hidden;
}
.ig-preview-img{
  width:100%;
  display:block;
  aspect-ratio: 1 / 1;      /* 正方形っぽく */
  object-fit: cover;
}

/* drop */
.ig-drop{
  border:1px dashed #314454;
  border-radius:14px;
  background:#0b141c;
  padding:14px 14px;
  text-align:center;
  cursor:pointer;
}
.ig-drop-title{ font-weight:800; color:#e6edf3; }
.ig-drop-sub{ color:#9aa7b4; font-size:13px; margin-top:4px; }
.ig-file{ display:none; }
.ig-help{ color:#9aa7b4; font-size:12px; }

/* textarea */
.ig-textarea{
  width:100%;
  border:1px solid #22303c;
  background:#0b141c;
  color:#e6edf3;
  border-radius:12px;
  padding:12px 12px;
  outline:none;
  resize: vertical;
}
.ig-textarea::placeholder{ color:#7f8c97; }
.ig-textarea:focus{
  border-color: rgba(29,155,240,.8);
  box-shadow: 0 0 0 4px rgba(29,155,240,.12);
}

/* tags */
.ig-tags{
  display:flex;
  flex-wrap:wrap;
  gap:10px;
}
.ig-tag-check{ display:none; }
.ig-tag{
  border:1px solid #22303c;
  background:#0b141c;
  color:#c7d2db;
  border-radius:999px;
  padding:7px 12px;
  font-size:13px;
  cursor:pointer;
  user-select:none;
}
.ig-tag-check:checked + .ig-tag{
  border-color: rgba(29,155,240,.75);
  background: rgba(29,155,240,.15);
  color:#8fd3ff;
  font-weight:700;
}

/* button */
.ig-post-btn{
  height:38px;
  border:0;
  border-radius:10px;
  background:#1d9bf0;
  color:#fff;
  font-weight:800;
  padding:0 14px;
}
.ig-post-btn:active{ background:#1384cf; }

.ig-create-foot{
  padding: 14px 16px 18px;
  border-top:1px solid #22303c;
}

/* error */
.ig-error{
  color:#ff8a8a;
  font-size:13px;
}
</style>
@endsection

