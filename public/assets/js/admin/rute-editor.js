(async()=>{
 'use strict';
 const root=document.querySelector('[data-route-editor]');if(!root)return;
 const points=JSON.parse(root.dataset.points||'[]'),errors=JSON.parse(root.dataset.errors||'{}');
 const list=root.querySelector('[data-route-points]'),message=root.querySelector('[data-route-message]');
 const versions=new WeakMap();let map,drawn=[],active=null;
 function button(label,action,danger=false){const node=document.createElement('button');node.type='button';node.className=(danger?'danger':'outline')+' small';node.textContent=label;node.onclick=action;return node;}
 function edit(point){active=point;map?.setSearchContext(point);if(map)map.flyTo([point.lat,point.lng]);message.textContent='Lokasi Titik '+(points.indexOf(point)+1)+' sedang diedit. Cari alamat atau pilih titik baru pada peta.';render();}
 function draw(){
  drawn.forEach(item=>item.remove());drawn=[];if(!map)return;
  points.forEach((point,index)=>drawn.push(map.marker({lat:+point.lat,lng:+point.lng,label:point.nama,address:point.keterangan},{number:index+1,onClick:()=>edit(point),onDrag:(lat,lng)=>map.selectLocation(lat,lng,null,true,point)})));
  if(points.length>1)drawn.push(map.line(points));
 }
 function render(){
  list.replaceChildren();
  points.forEach((point,index)=>{
   const box=document.createElement('div');box.className='point-editor';if(point===active)box.setAttribute('aria-current','true');
   const header=document.createElement('header'),title=document.createElement('strong');title.textContent='Titik '+(index+1);
   header.append(title,button('Ubah lokasi',()=>edit(point)),button('↑',()=>{if(index){[points[index-1],points[index]]=[points[index],points[index-1]];render();}}),button('↓',()=>{if(index<points.length-1){[points[index+1],points[index]]=[points[index],points[index+1]];render();}}),button('Hapus',()=>{points.splice(index,1);if(active===point)active=null;map?.setSearchContext(active);render();},true));box.append(header);
   const grid=document.createElement('div');grid.className='form-grid';
   for(const [key,label,type] of [['nama','Nama titik','text'],['keterangan','Alamat / keterangan','text'],['jam_rencana','Jam rencana','time']]){
    const field=document.createElement('div'),caption=document.createElement('label'),input=document.createElement('input');field.className='field';input.id='point-'+index+'-'+key;caption.htmlFor=input.id;caption.textContent=label;input.name='titik['+index+']['+key+']';input.type=type;input.value=key==='jam_rencana'?(point[key]||'07:00').slice(0,5):(point[key]||'');input.required=key!=='keterangan';input.maxLength=key==='nama'?180:500;input.addEventListener('input',()=>{point[key]=input.value;draw();});field.append(caption,input);
    if(errors['titik.'+index+'.'+key]){const error=document.createElement('small');error.className='error';error.textContent=errors['titik.'+index+'.'+key].join(' ');field.append(error);}grid.append(field);
   }
   box.append(grid);
   for(const [key,value] of [['lat',point.lat],['lng',point.lng],['urutan',index+1]]){const input=document.createElement('input');input.type='hidden';input.name='titik['+index+']['+key+']';input.value=value;box.append(input);if(errors['titik.'+index+'.'+key]){const error=document.createElement('small');error.className='error';error.textContent=errors['titik.'+index+'.'+key].join(' ');box.append(error);}}
   list.append(box);
  });draw();
 }
 const area=document.getElementById('wilayah_id'),petugas=document.getElementById('petugas_id'),jadwal=document.getElementById('jadwal_id');
 const staffAreas=JSON.parse(root.dataset.petugasAreas||'{}'),scheduleAreas=JSON.parse(root.dataset.jadwalAreas||'{}');
 function filter(){for(const option of petugas.options){if(!option.value)continue;const permitted=(staffAreas[option.value]||[]).map(String).includes(area.value);option.hidden=!permitted;option.disabled=!permitted;if(option.selected&&!permitted)petugas.value='';}for(const option of jadwal.options){if(!option.value)continue;const permitted=String(scheduleAreas[option.value])===area.value;option.hidden=!permitted;option.disabled=!permitted;if(option.selected&&!permitted)jadwal.value='';}}
 area.addEventListener('change',filter);filter();render();
 root.querySelector('[data-route-add]')?.addEventListener('click',()=>{active=null;map?.setSearchContext(null);message.textContent='Cari alamat atau klik peta untuk menambah titik baru.';render();});
 try{
  map=await PantasMap.picker(root.querySelector('[data-route-map]'),{root,context:()=>active,onReject:draw,onSelect:(location,meta)=>{
   let point=meta.context;
   if(meta.phase==='address'){
    if(!point||!points.includes(point))return;
    const previous=versions.get(point);
    if(previous?.version!==meta.version)return;
    if(point.nama===previous.nama)point.nama=location.label.slice(0,180);
    if(point.keterangan===previous.keterangan)point.keterangan=location.label.slice(0,500);
   }else{
    if(point&&!points.includes(point))return;
    if(!point){point={nama:'',keterangan:'',jam_rencana:'07:00'};points.push(point);}
    point.lat=location.lat;point.lng=location.lng;
    point.nama=location.label?.slice(0,180)||'';point.keterangan=location.label?.slice(0,500)||'';
    versions.set(point,{version:meta.version,nama:point.nama,keterangan:point.keterangan});
   }
   render();return point;
  }});
  render();if(points.length)map.fit(points);
 }catch(error){message.textContent=error.message;}
})();
