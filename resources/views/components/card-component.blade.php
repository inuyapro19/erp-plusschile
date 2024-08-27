<div class="card card-flush {{$classCard}}" style="margin-top:200px">
   @if($header)
        <div class="card-header">
            <h3 class="card-title">
                {{$title}}
            </h3>
        </div>
   @endif
    <div class="card-body {{$bodyClass}}">
        {{$slot}}
    </div>
</div>
