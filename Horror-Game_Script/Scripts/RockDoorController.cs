using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class RockDoorController : MonoBehaviour
{
    public bool lockType = true;  //鍵がかかっているかどうか
    public bool doorMove = false;  //ドアが開いているかどうかを判定する
    public string keyName;  //対応する鍵の名前を格納する
    private Animator anime;
    public AudioSource rockAudio;
    public AudioSource doorAudio;
    public AudioSource rockOpenAudio;

    // Start is called before the first frame update
    void Start()
    {
        anime = GetComponent<Animator>();
    }

    // Update is called once per frame
    void Update()
    {
        
    }
    public void DoorMove()
    {
        if (doorMove == false)  //開ける
        {
            anime.SetBool("Rock Close", false);
            anime.SetBool("Rock Open", true);
        }
        else if (doorMove)  //閉じる
        {
            anime.SetBool("Rock Open", false);
            anime.SetBool("Rock Close", true);
        }
        doorMove = !doorMove;
        doorAudio.Play();
    }

}
