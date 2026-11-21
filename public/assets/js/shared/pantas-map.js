(()=>{
 'use strict';
 const config=window.PANTAS_MAP_CONFIG||{},color={warga:'#039855',petugas:'#2c5e8f',admin:'#101828'}[document.body.dataset.role]||'#039855';
 let googleReady,boundaryReady;
 function say(root,text){const message=root?.querySelector('[data-map-message],[data-route-message]');if(message)message.textContent=text;}
 function ring(lat,lng,points){let inside=false;for(let i=0,j=points.length-1;i<points.length;j=i++){const [xi,yi]=points[i],[xj,yj]=points[j];const cross=(lng-xi)*(yj-yi)-(lat-yi)*(xj-xi);if(Math.abs(cross)<1e-12&&lng>=Math.min(xi,xj)&&lng<=Math.max(xi,xj)&&lat>=Math.min(yi,yj)&&lat<=Math.max(yi,yj))return true;if((yi>lat)!==(yj>lat)&&lng<(xj-xi)*(lat-yi)/(yj-yi)+xi)inside=!inside;}return inside;}
 async function contains(lat,lng){boundaryReady??=fetch(config.boundary_url||'/assets/data/surabaya.geojson').then(response=>{if(!response.ok)throw Error('Batas layanan belum tersedia. Coba lagi setelah memuat ulang halaman.');return response.json();});if(!Number.isFinite(+lat)||!Number.isFinite(+lng))return false;const feature=await boundaryReady,geometry=feature.geometry,polygons=geometry.type==='Polygon'?[geometry.coordinates]:geometry.coordinates;return polygons.some(rings=>ring(lat,lng,rings[0])&&!rings.slice(1).some(hole=>ring(lat,lng,hole)));}
 function loadGoogle(){googleReady??=new Promise((resolve,reject)=>{if(window.google?.maps?.importLibrary){resolve();return;}window.pantasGoogleReady=resolve;const script=document.createElement('script');script.src='https://maps.googleapis.com/maps/api/js?key='+encodeURIComponent(config.google_browser_key)+'&language=id&region=ID&loading=async&v=weekly&callback=pantasGoogleReady';script.async=true;script.onerror=()=>reject(Error('Google Maps belum dapat dimuat.'));document.head.append(script);setTimeout(()=>reject(Error('Google Maps belum merespons.')),15000);});return googleReady;}
 async function create(el,root){
  const center=config.default_center||{lat:-7.2575,lng:112.7521};
  if(config.provider==='google'&&config.google_browser_key){try{await loadGoogle();const [{Map,Polyline},{AdvancedMarkerElement}]=await Promise.all([google.maps.importLibrary('maps'),google.maps.importLibrary('marker')]);const map=new Map(el,{center,zoom:config.default_zoom||13,mapId:config.google_map_id,streetViewControl:false,mapTypeControl:false});
   return {provider:'google',native:map,onClick:callback=>map.addListener('click',event=>callback(event.latLng.lat(),event.latLng.lng())),flyTo:(point,zoom=16)=>{map.panTo({lat:+point[0],lng:+point[1]});map.setZoom(zoom);},fit:points=>{if(!points.length)return;const bounds=new google.maps.LatLngBounds();points.forEach(point=>bounds.extend({lat:+point.lat,lng:+point.lng}));map.fitBounds(bounds,40);google.maps.event.addListenerOnce(map,'idle',()=>{if(map.getZoom()>16)map.setZoom(16);});},marker:(point,options={})=>{const content=document.createElement('span');content.className='pantas-pin';content.style.background=color;content.textContent=options.number||'•';const marker=new AdvancedMarkerElement({map,position:{lat:+point.lat,lng:+point.lng},title:point.label||'',content,gmpDraggable:!!options.onDrag,gmpClickable:true});marker.addListener('click',()=>{if(options.onClick)options.onClick();else{const text=document.createElement('div');text.textContent=[point.label,point.address].filter(Boolean).join(' — ');new google.maps.InfoWindow({content:text}).open({map,anchor:marker});}});if(options.onDrag)marker.addListener('dragend',event=>options.onDrag(event.latLng.lat(),event.latLng.lng()));return {remove:()=>marker.map=null,setPosition:(lat,lng)=>marker.position={lat,lng}};},line:points=>{const line=new Polyline({map,path:points.map(point=>({lat:+point.lat,lng:+point.lng})),strokeColor:'#2c5e8f',strokeWeight:4});return {remove:()=>line.setMap(null)};},reverse:async(lat,lng)=>{const {Geocoder}=await google.maps.importLibrary('geocoding');const response=await new Geocoder().geocode({location:{lat,lng},language:'id',region:'ID'});return response.results[0]?googlePoint(response.results[0]):null;},search:async(q)=>{const {Geocoder}=await google.maps.importLibrary('geocoding');try{const response=await new Geocoder().geocode({address:/surabaya/i.test(q)?q:q+', Surabaya, Jawa Timur, Indonesia',bounds:config.bounds,componentRestrictions:{country:'ID'},language:'id',region:'ID'});return response.results.map(googlePoint);}catch(error){if(error.code==='ZERO_RESULTS')return [];throw error;}}};
  }catch(error){say(root,'Google Maps belum tersedia. Peta OpenStreetMap digunakan; pilih titik secara manual.');}}
  else if(config.provider!=='geoapify')say(root,'Google Maps belum dikonfigurasi. Peta OpenStreetMap tersedia untuk pemilihan titik manual dan pencarian melalui tombol Cari.');
  if(!window.L){el.textContent='Peta belum dapat dimuat. Periksa koneksi internet.';throw Error('Leaflet belum tersedia.');}
  const map=L.map(el).setView([center.lat,center.lng],config.default_zoom||13);L.tileLayer(config.tile_url,{attribution:config.attribution,maxZoom:19}).addTo(map);setTimeout(()=>map.invalidateSize(),150);
  return {provider:'osm',native:map,onClick:callback=>map.on('click',event=>callback(event.latlng.lat,event.latlng.lng)),flyTo:(point,zoom=16)=>map.flyTo(point,zoom),fit:points=>{if(points.length)map.fitBounds(L.latLngBounds(points.map(point=>[point.lat,point.lng])).pad(.2),{maxZoom:16});},marker:(point,options={})=>{const content=document.createElement('span');content.className='pantas-pin';content.style.background=color;content.textContent=options.number||'•';const marker=L.marker([point.lat,point.lng],{draggable:!!options.onDrag,icon:L.divIcon({className:'',html:content.outerHTML,iconSize:[30,30],iconAnchor:[15,15]})}).bindPopup(document.createTextNode([point.label||'Lokasi',point.address].filter(Boolean).join(' — '))).addTo(map);if(options.onClick)marker.on('click',options.onClick);if(options.onDrag)marker.on('dragend',()=>{const point=marker.getLatLng();options.onDrag(point.lat,point.lng);});return {remove:()=>marker.remove(),setPosition:(lat,lng)=>marker.setLatLng([lat,lng])};},line:points=>{const line=L.polyline(points.map(point=>[point.lat,point.lng]),{color:'#2c5e8f',weight:4}).addTo(map);return {remove:()=>line.remove()};},reverse:async(lat,lng)=>{const response=await fetch(`/api/geocode/reverse?lat=${lat}&lng=${lng}`,{headers:{Accept:'application/json'}});if(!response.ok)throw Error('Alamat belum tersedia.');return (await response.json())[0]||null;},search};
 }
 async function search(q){const response=await fetch('/api/geocode/search?q='+encodeURIComponent(q),{headers:{Accept:'application/json'}});if(!response.ok){const error=await response.json();throw Error(error.message||'Pencarian belum tersedia. Tandai langsung pada peta.');}return response.json();}

 function googlePoint(result){
  const components=result.address_components||result.addressComponents||[];
  const component=components.find(item=>item.types?.includes('administrative_area_level_3'));
  return {lat:result.geometry?.location.lat()??result.location?.lat(),lng:result.geometry?.location.lng()??result.location?.lng(),label:result.formatted_address||result.formattedAddress,district:component?.long_name||component?.longText};
 }
 const messages={empty:'Lokasi tidak ditemukan. Coba gunakan nama jalan yang lebih lengkap atau pilih titik langsung pada peta.',search:'Pencarian lokasi sedang tidak tersedia. Silakan coba lagi atau tentukan titik secara manual.',reverse:'Alamat otomatis tidak ditemukan. Silakan lengkapi alamat secara manual.',pending:'Alamat pencarian berubah. Tekan Cari dan pilih hasil, atau pilih titik pada peta sebelum menyimpan.'};
 async function picker(el,options={}){
  const root=options.root||el.parentElement,map=await create(el,root);
  const input=root.querySelector('[data-map-search],[data-route-search]');
  const target=root.dataset.addressTarget?document.getElementById(root.dataset.addressTarget):root.querySelector('[data-map-address]');
  const latField=root.querySelector('[data-map-lat]'),lngField=root.querySelector('[data-map-lng]');
  const results=root.querySelector('[data-map-results],[data-route-results]');
  const form=root.closest('form'),area=form?.querySelector('[name=wilayah_id]');
  const centers=JSON.parse(root.dataset.centers||'{}');
  let pin,autocomplete,selected=null,version=0,detailVersion=0,pending=false,baseline='',busy=false,syncingArea=false;
  function status(text,loading=false){if(config.provider==='geoapify'){const info=root.querySelector('[data-map-provider]');if(info)info.hidden=true;}busy=loading;root.setAttribute('aria-busy',String(loading));say(root,text);}
  function validateQuery(){input?.setCustomValidity(pending?messages.pending:'');}
  function write(field,value){if(!field)return;field.value=value;field.dispatchEvent(new Event('change',{bubbles:true}));}
  function syncArea(point){
   if(!point.district||!area)return;
   const normalize=value=>String(value).toLowerCase().replace(/^kecamatan\s+|^kec\.?\s+/g,'').replace(/\s+/g,'').replace('pabeancantikan','pabeancantian');
   const match=[...area.options].find(option=>option.value&&normalize(option.textContent)===normalize(point.district));
   if(match){area.value=match.value;syncingArea=true;area.dispatchEvent(new Event('change',{bubbles:true}));syncingArea=false;}
  }
  function place(point){pin?.remove();pin=map.marker(point,{onDrag:(lat,lng)=>select(lat,lng,null,true)});}
  function providerSuccess(){if(config.provider!=='geoapify')return;const info=root.querySelector('[data-map-provider]');if(info){info.textContent='Peta OpenStreetMap • Pencarian alamat menggunakan Geoapify.';info.hidden=false;}}
  function queryLabel(label){baseline=label||'';if(input)input.value=baseline;if(autocomplete)autocomplete.value=baseline;pending=false;validateQuery();}
  function apply(point,meta){
   selected=point;
   if(options.onSelect)return options.onSelect(point,meta);
   write(latField,point.lat);write(lngField,point.lng);
   if(point.label)write(target,point.label);
   place(point);syncArea(point);
  }
  async function select(lat,lng,label,reverse=false,explicitContext){
   const current=++version,details=detailVersion;
   let context=explicitContext===undefined?options.context?.():explicitContext;
   status('Memeriksa lokasi…',true);
   try{
    const allowed=await contains(+lat,+lng);if(current!==version)return;
    if(!allowed){if(selected&&!options.onSelect)pin?.setPosition(selected.lat,selected.lng);options.onReject?.();status('Titik berada di luar Kota Surabaya. Pilih lokasi di dalam area layanan.');return;}
    const point={lat:+lat,lng:+lng,label:label&&typeof label==='object'?label.label:label,district:label&&typeof label==='object'?label.district:null};
    const result=apply(point,{context,phase:'coordinates',version:current});context=result??context;
    if(reverse&&!options.onSelect)write(target,'');
    queryLabel(point.label);results?.replaceChildren();map.flyTo([point.lat,point.lng]);
    if(!reverse){status('Lokasi dipilih. Lengkapi detail alamat bila diperlukan.');if(label)providerSuccess();return;}
    status('Mencari alamat titik terpilih…',true);
    try{
     const address=await map.reverse(point.lat,point.lng);if(current!==version)return;
     if(!address?.label){status(messages.reverse);return;}
     const updated={...point,label:address.label,district:address.district};
     selected=updated;
     if(options.onSelect)options.onSelect(updated,{context,phase:'address',version:current});
     else{if(detailVersion===details)write(target,updated.label);syncArea(updated);}
     queryLabel(updated.label);status('Lokasi dan alamat diperbarui. Lengkapi detail alamat bila diperlukan.');providerSuccess();
    }catch{if(current===version)status(messages.reverse);}
   }catch(error){if(current===version){if(selected&&!options.onSelect)pin?.setPosition(selected.lat,selected.lng);options.onReject?.();status(error.message||messages.search);}}
  }
  map.onClick((lat,lng)=>select(lat,lng,null,true));
  async function find(){
   const query=input?.value.trim();if(!query)return;
   const current=++version;pending=true;validateQuery();results?.replaceChildren();status('Mencari lokasi…',true);
   try{
    const data=await map.search(query);if(current!==version)return;
    if(!Array.isArray(data))throw Error(messages.search);
    const filtered=[];for(const point of data){if(point.label&&await contains(+point.lat,+point.lng))filtered.push(point);}
    if(current!==version)return;
    if(filtered.length===1){await select(filtered[0].lat,filtered[0].lng,filtered[0]);return;}
    filtered.forEach(point=>{const button=document.createElement('button');button.type='button';button.className='map-result';button.textContent=point.label;button.onclick=()=>select(point.lat,point.lng,point);results?.append(button);});
    status(filtered.length?'Pilih alamat yang sesuai dari hasil pencarian.':messages.empty);
   }catch(error){if(current===version)status(error.message||messages.search);}
  }
  root.querySelector('[data-map-search-button],[data-route-search-button]')?.addEventListener('click',find);
  input?.addEventListener('keydown',event=>{if(event.key==='Enter'){event.preventDefault();find();}});
  input?.addEventListener('input',()=>{++version;results?.replaceChildren();pending=!!input.value.trim()&&input.value!==baseline;validateQuery();status(pending?messages.pending:'Pilih lokasi melalui pencarian atau peta.');});
  target?.addEventListener('input',()=>{++detailVersion;});
  form?.addEventListener('submit',event=>{if(pending||busy){event.preventDefault();status(pending?messages.pending:'Tunggu pemeriksaan lokasi selesai sebelum menyimpan.');input?.focus();}});
  const provider=document.createElement('small');provider.dataset.mapProvider='';provider.hidden=config.provider==='geoapify';provider.textContent=config.provider==='geoapify'?'':map.provider==='google'?'Pencarian menggunakan Google Maps.':'Google Maps belum tersedia atau API key belum dikonfigurasi. Mode OpenStreetMap aktif; pencarian bergantung pada layanan geocoding yang dikonfigurasi.';root.querySelector('[data-map-message],[data-route-message]')?.after(provider);
  const googleContainer=root.querySelector('[data-google-search]');
  if(map.provider==='google'&&googleContainer){
   try{
    const {PlaceAutocompleteElement}=await google.maps.importLibrary('places');
    autocomplete=new PlaceAutocompleteElement({includedRegionCodes:['id'],locationRestriction:config.bounds});
    autocomplete.placeholder='Cari alamat atau nama jalan';googleContainer.append(autocomplete);
    autocomplete.addEventListener('gmp-select',async({placePrediction})=>{
     const current=++version;pending=true;validateQuery();status('Mencari lokasi…',true);
     try{const place=placePrediction.toPlace();await place.fetchFields({fields:['formattedAddress','location','addressComponents']});if(current!==version)return;if(place.location){const point=googlePoint(place);await select(point.lat,point.lng,point);}else status(messages.empty);}catch(error){if(current===version)status(error.message||messages.search);}
    });
    autocomplete.addEventListener('input',()=>{++version;if(input)input.value=autocomplete.value;pending=!!autocomplete.value?.trim()&&autocomplete.value!==baseline;validateQuery();status(pending?messages.pending:'Pilih lokasi melalui pencarian atau peta.');});
    autocomplete.addEventListener('gmp-error',()=>{++version;status(messages.search);});
   }catch{status('Saran Google Places belum tersedia. Gunakan tombol Cari atau pilih titik pada peta.');}
  }
  if(latField?.value&&lngField?.value){
    selected={lat:+latField.value,lng:+lngField.value,label:target?.value};
    place(selected);queryLabel(selected.label);
    map.flyTo([selected.lat,selected.lng]);
  }else if(area?.value&&centers[area.value]){
    const center=centers[area.value];
    const point={lat:+center.lat,lng:+center.lng,label:center.nama,district:center.nama};
    place(point);write(latField,point.lat);write(lngField,point.lng);
    map.flyTo([center.lat,center.lng],15);
  }
  area?.addEventListener('change',()=>{
    if(syncingArea)return;
    const center=centers[area.value];
    if(center){
      map.flyTo([center.lat,center.lng],15);
      const point={lat:+center.lat,lng:+center.lng,label:center.nama,district:center.nama};
      place(point);write(latField,point.lat);write(lngField,point.lng);
      if(target&&!target.value.trim()){write(target,'Kecamatan '+center.nama+', Surabaya');}
      status('Peta diarahkan ke Kecamatan '+center.nama+'. Titik koordinat disesuaikan.');
    }
  });
  map.selectLocation=select;
  map.setSearchContext=point=>{++version;selected=point||null;queryLabel(point?.label||point?.nama);results?.replaceChildren();status('Cari atau pilih titik untuk lokasi yang sedang diedit.');};
  root.pantasMap=map;el.pantasMap=map;root.dispatchEvent(new CustomEvent('pantas-map-ready'));return map;
 }
 async function viewer(el,options={}){const map=await create(el,el.parentElement),points=options.markers||[];points.forEach(point=>map.marker(point,{number:point.number}));if(options.polyline&&points.length>1)map.line(points);if(options.fit!==false)map.fit(points);el.pantasMap=map;return map;}
 window.PantasMap={create,picker,viewer,search,contains};
 document.querySelectorAll('[data-map-viewer]').forEach(el=>viewer(el,{markers:JSON.parse(el.dataset.markers||'[]'),polyline:el.dataset.polyline==='1'}).catch(error=>el.textContent=error.message));
 document.querySelectorAll('[data-map-picker]').forEach(root=>picker(root.querySelector('[data-map-canvas]'),{root}).catch(error=>say(root,error.message)));
})();