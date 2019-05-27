package com.unsil.if16.volunteer;

import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import java.util.List;

public class ListEventAdapter extends RecyclerView.Adapter<ListEventAdapter.MyViewHolder>{
    public interface OnItemClickListener {
        void onItemClick(Event event);
    }
    private List<Event>         listEvent;
    private OnItemClickListener listener;

    public ListEventAdapter(List<Event> daftarKonsul, OnItemClickListener _listener) {
        this.listEvent = daftarKonsul;
        this.listener = _listener;
    }

    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View itemView = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.event_list_view, parent, false);

        return new MyViewHolder(itemView);
    }

    @Override
    public void onBindViewHolder(MyViewHolder holder, int position) {
        Event event= listEvent.get(position);
        holder.nama.setText(event.getNama_event());
        holder.deskripsi.setText(event.getDeskripsi());
        holder.bind(listEvent.get(position), listener);
    }

    @Override
    public int getItemCount() {
        return listEvent.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        public TextView nama, tanggal, deskripsi;

        public MyViewHolder(View view) {
            super(view);
            nama = (TextView) view.findViewById(R.id.nama);
            deskripsi = (TextView) view.findViewById(R.id.deskripsi);
        }

        public void bind(final Event event, final OnItemClickListener listener) {
            //name.setText(item.name);
            //Picasso.with(itemView.getContext()).load(item.imageUrl).into(image);
            itemView.setOnClickListener(new View.OnClickListener() {
                @Override public void onClick(View v) {
                    listener.onItemClick(event);
                }
            });
        }
    }

}
