using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class LockController : MonoBehaviour
{
    public bool lockType = true;  //鍵がかかっているかどうか
    public bool doorMove = false;  //ドアが開いているかどうかを判定する
    public string doorName;  //ドアの名前を格納する
    public string keyName;  //対応する鍵の名前を格納する
    private Animator anime;  //ドアの開閉アニメーション
    public AudioSource doorAudio;  //ドアの開閉音
    public AudioSource lockAudio;  //ドアの解錠・施錠音
    public AudioSource failAudio;  //鍵がかかっている時の音

    public bool canF;
    public bool canB;
    private bool f_Point;  //表から開けたらtrue,閉めるとfalse
    private bool b_Point;  //裏から開けたらtrue,閉めるとfalse

    // Start is called before the first frame update
    void Start()
    {
        anime = GetComponent<Animator>();
    }
    public void DoorMove()
    {
        if (doorMove == false)  //状態：閉じている　操作：開ける
        {
            if (canF)
            {
                anime.SetBool("Close_f", false);
                anime.SetBool("Open_f", true);
                f_Point = true;
            }
            if (canB)
            {
                anime.SetBool("Close_b", false);
                anime.SetBool("Open_b", true);
                b_Point = true;
            }
        }
        else if (doorMove)  //状態：開いている　操作：閉じる
        {
            if (f_Point)
            {
                anime.SetBool("Open_f", false);
                anime.SetBool("Close_f", true);
                f_Point = false;
            }
            if (b_Point)
            {
                anime.SetBool("Open_b", false);
                anime.SetBool("Close_b", true);
                b_Point = false;
            }
        }
        doorMove = !doorMove;  //ドアが開いているかどうかを判定
        doorAudio.Play();  //開閉音を再生    }

    }
}

